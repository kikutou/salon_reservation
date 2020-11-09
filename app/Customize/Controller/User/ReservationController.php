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

use Customize\Entity\Menu;
use Customize\Entity\Shop;
use Customize\Repository\MenuRepository;
use Customize\Repository\ShopRepository;
use Customize\Repository\StaffRepository;
use Eccube\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;


class ReservationController extends AbstractController
{
    /**
     * @var EncoderFactoryInterface
     */
    protected $encoderFactory;
    protected $staffRepository;
    protected $shopRepository;
    protected $menuRepository;

    public function __construct(
        EncoderFactoryInterface $encoderFactory,
		StaffRepository $staffRepository,
		ShopRepository $shopRepository,
		MenuRepository $menuRepository
    ) {
        $this->encoderFactory = $encoderFactory;
        $this->staffRepository = $staffRepository;
        $this->shopRepository = $shopRepository;
        $this->menuRepository = $menuRepository;
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

    	$store_id = $shop->getHotpepperStoreId();
    	$menu_id = $menu->getHotpepperMenuId();

    	// "https://beauty.hotpepper.jp/CSP/bt/reserve/?storeId=H000116656&menuId=MN00000003717887&add=0&addMenu=0&rootCd=10"
        $url = "https://beauty.hotpepper.jp/CSP/bt/reserve/?storeId=" . $store_id . "&menuId=" . $menu_id . "&addMenu=0&rootCd=10";

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
        ];
    }

   
   
}
