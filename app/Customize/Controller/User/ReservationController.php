<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Customize\Controller\User;

use Twilio\Rest\Client;
use Customize\Entity\Reservation;
use Customize\Form\Type\Admin\ReservationType;
use Eccube\Repository\CustomerRepository;
use Customize\Repository\MenuRepository;
use Customize\Repository\ReservationRepository;
use Customize\Repository\ShopRepository;
use Customize\Repository\StaffRepository;
use Eccube\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Aws\Credentials\Credentials;
use Aws\Polly\PollyClient;


class ReservationController extends AbstractController
{
    /**
     * @var EncoderFactoryInterface
     * @var CustomerRepository
     */
    protected $encoderFactory;
    protected $staffRepository;
    protected $shopRepository;
    protected $menuRepository;
    protected $reservationRepository;
    protected $customerRepository;

    public function __construct(
        EncoderFactoryInterface $encoderFactory,
		StaffRepository $staffRepository,
		ShopRepository $shopRepository,
        MenuRepository $menuRepository,
        ReservationRepository $reservationRepository,
        CustomerRepository $customerRepository
    ) {
        $this->encoderFactory = $encoderFactory;
        $this->staffRepository = $staffRepository;
        $this->shopRepository = $shopRepository;
        $this->menuRepository = $menuRepository;
        $this->reservationRepository = $reservationRepository;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @Route("/user/reservation/{shop_id}/{menu_id}", name="user_reservation")
     * @Template("@user_data/Reservation/index.twig")
     */
    public function index(Request $request, string $shop_id, string $menu_id)
    {

    	$shop = $this->shopRepository->find($shop_id);
    	$menu = $this->menuRepository->find($menu_id);
    	if(!$shop || !$menu) {
    		throw new NotFoundHttpException();
	    }

    	$storeId = $shop->getHotpepperStoreId();
    	$menuId = $menu->getHotpepperMenuId();

    	// "https://beauty.hotpepper.jp/CSP/bt/reserve/?storeId=H000116656&menuId=MN00000003717887&add=0&addMenu=0&rootCd=10"
        $url = "https://beauty.hotpepper.jp/CSP/bt/reserve/?storeId=" . $storeId . "&menuId=" . $menuId . "&addMenu=0&rootCd=10";

        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        
        $html = curl_exec($ch);
        
        if($html === FALSE ){
            throw new NotFoundHttpException();
        }

        try {
	        curl_close($ch);
	        $str = '<div id="jsRsvCdTbl" class="reserveConditionTable  jscInnerTableWrap">';
	        $arr = explode($str, $html);
	        $arr = explode('</div>', $arr[1]);
	        $output = $str . $arr[0] . '</div>';

	        // ヘッダー日付の変換
	        $headerHtml = explode('<tr class="dayCellContainer">', $output);
	        $headerHtml = explode('</tr', $headerHtml[1]);
	        $dateArray = explode('</th>', $headerHtml[0]);
        } catch (\Exception $e) {
        	throw new NotFoundHttpException($e->getMessage());
        }
        

        
        foreach ($dateArray as $key => $date) {
            if ($key <= 13) {
                $headerStr = substr($date, -38, 28);
                $replaceHeaderStr = ltrim(substr($date, -30, 2), '0');
                $output = str_replace($headerStr, $replaceHeaderStr, $output);
            }
        }
        $output = str_replace('※来店日条件：指定なし', '', $output);




        // スタッフリスト
        $Staffs = $this->staffRepository->findBy(array("shopId" => $shop_id));
        $outputStaff = [];
        if (count($Staffs) > 0) {
            foreach ($Staffs as $Staff) {
	            $outputStaff[$Staff->getId()] = [
		            'name' => $Staff->getName(),
		            'image' => $Staff->getImage(),
	            ];
            }
        }

        return [
            'content' => $output,
            'Staffs' => $outputStaff,
            'shop_id' => $shop_id,
            'menu_id' => $menu_id
        ];
    }

    /**
     * @Route("/reservation/confirm", name="reservation_confirm")
     * @Template("@user_data/Reservation/confirm.twig")
     */
    public function confirm(Request $request)
    {

	    $user = $this->getUser();
        if(!$user) {
	        return $this->redirectToRoute('mypage_login');

        }

        $Reservation = new Reservation();
        if (!is_null($request->get('reservationId'))) {
            $Reservation = $this->reservationRepository->find($request->get('reservationId'));
        }
        $starttime = $request->get('rsvDate'). $request->get('rsvTime');
        $menu = $this->menuRepository->find($request->get('menuId')); 
        $shop = $this->shopRepository->find($request->get('shopId'));
        $staff = !is_null($request->get('staffId')) ? $this->staffRepository->find($request->get('staffId')) : null;
        
        if(!$user || !$menu || !$shop) {
            throw new NotFoundHttpException();
        }
        
        $builder = $this->formFactory->createBuilder(ReservationType::class, $Reservation);
        $form = $builder->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $Reservation = $form->getData();
            $Reservation->setCreatedAt(new \DateTime());
            $Reservation->setStarttime($request->get('starttime'));
            $Reservation->setStatus(2); // 予約済
            $Reservation->setPointSumBeforeReservation($user->getPoint());
            $Reservation->setCustomer($user);
            $Reservation->setMenu($menu);
            $Reservation->setShopId($request->get('shopId'));
            $Reservation->setStaff($staff);
            
            $this->reservationRepository->save($Reservation);
            
            $this->addSuccess('admin.common.save_complete', 'admin');
            log_info('予約情報登録完了', [$Reservation->getId()]);

            // Twilio アカウント情報
            $account_sid = env('TWILIO_SID');
            $auth_token = env('TWILIO_TOKEN');

            // A Twilio number you own with SMS capabilities
            $twilio_number = env('TWILIO_NUMBER');
            $shop_number = '+81'. substr($shop->getTelephone(), 1);

            // // テキストからmp3に変換
            // $credentials = new Credentials(
            //     env('AWS_KEY'),
            //     env('AWS_SECRET_KEY'));
    
            // $client = new PollyClient([
            //     'region' => env('AWS_REGION'),
            //     'version' => env('AWS_VERSION'),
            //     'credentials' => $credentials
            // ]);

            // $result = $client->synthesizeSpeech([
            //     'Text' => '予約を取りました。',
            //     'OutputFormat' => 'mp3',
            //     'VoiceId' => 'Mizuki',
            // ]);
    
            // $voice_path = $this->eccubeConfig['eccube_temp_image_dir'] . '/rev_call.mp3';
    
            // // mp3生成
            // file_put_contents($voice_path, $result['AudioStream']);

            $voiceUrl = ($request->isSecure() ? "https://" : "http://") . $request->getHost() . "/reservation/call";

            try {

            	$client = new Client($account_sid, $auth_token);
                $client->messages->create(
                    // メッセージ
                    $shop_number,
                    [
                        'from' => $twilio_number,
                        'body' => '予約を取りました。'
                    ]
                );

                $client->calls->create(
                    // 電話
                    $shop_number,
                    $twilio_number,
                    [
                        'url' => $voiceUrl
                    ]
                );
            } catch (\Exception $e) {

            	exit(var_dump($e));
                throw new \Exception("予約情報の発信は失敗になりました。");
            }

	        return $this->redirectToRoute("reservation_finish", [
	        	"id" => $Reservation->getId()
	        ]);
        }
        return [
            'staff' => $staff,
            'menu' => $menu,
            'shop' => $shop,
            'user' => $user,
            'starttime' => $starttime,
            'form' => $form->createView(),
            'Reservation' => $Reservation
        ];
    }

	/**
	 * @Route("/reservation/finish/{id}", name="reservation_finish")
	 * @Template("@user_data/Reservation/finish.twig")
	 */
    public function finish(Request $request, Reservation $reservation)
    {

	    return [
		    'reservation' => $reservation
	    ];
    }

   
    /**
     * @Route("/reservation/call", name="reservation_call")
     * @Template("@call.xml")
     */
    public function rsvCall(Request $request)
    {
        return new Response($this->renderView('call.xml'));
    }
}
