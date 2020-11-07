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

    public function __construct(
        EncoderFactoryInterface $encoderFactory,
		StaffRepository $staffRepository
    ) {
        $this->encoderFactory = $encoderFactory;
        $this->staffRepository = $staffRepository;
    }

    /**
     * @Route("/user/reservation", name="user_reservation")
     * @Template("@user_data/Reservation/index.twig")
     */
    public function index(Request $request)
    {
      
        $url = "https://beauty.hotpepper.jp/CSP/bt/reserve/?storeId=H000116656&couponId=CP00000007108646&add=0&addMenu=0&rootCd=10";
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        
        $html = curl_exec($ch);
        
        if($html === FALSE ){
            throw new NotFoundHttpException();
        }
        
        curl_close($ch);
        $str = '<div id="jsRsvCdTbl" class="reserveConditionTable  jscInnerTableWrap">';
        $arr = explode($str, $html);
        $arr = explode('</div>', $arr[1]);
        $output = $str . $arr[0] . '</div>';

        // ヘッダー日付の変換
        $headerHtml = explode('<tr class="dayCellContainer">', $output);
        $headerHtml = explode('</tr', $headerHtml[1]);
        $dateArray = explode('</th>', $headerHtml[0]);
        
        foreach ($dateArray as $key => $date) {
            if ($key <= 13) {
                $headerStr = substr($date, -38, 28);
                $replaceHeaderStr = ltrim(substr($date, -30, 2), '0');
                $output = str_replace($headerStr, $replaceHeaderStr, $output);
            }
        }
        $output = str_replace('※来店日条件：指定なし', '', $output);
        // スタッフリスト
        $Staffs = $this->staffRepository->findAll();
        $outputStaff = [];
        if (count($Staffs) > 0) {
            foreach ($Staffs as $Staff) {
                // todo shop id
                if ($Staff->getshopId() == 2) {
                    $outputStaff[$Staff->getId()] = [
                        'name' => $Staff->getName(), 
                        'image' => $Staff->getImage(),
                    ];
                }
            }
        }

        return [
            'content' => $output,
            'Staffs' => $outputStaff,
        ];
    }

   
   
}
