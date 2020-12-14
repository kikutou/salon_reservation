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

namespace Customize\Controller\Admin\Reservation;

use Customize\Entity\Reservation;
use Customize\Form\Type\Admin\ReservationType;
use Customize\Repository\ShopRepository;
use Customize\Repository\ReservationRepository;
use Eccube\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;


class ReservationEditController extends AbstractController
{
    protected $reservationRepository;

    /**
     * @var EncoderFactoryInterface
     */
    protected $encoderFactory;
    protected $shopRepository;

    public function __construct(
        ReservationRepository $reservationRepository,
        EncoderFactoryInterface $encoderFactory,
		ShopRepository $shopRepository
    ) {
        $this->reservationRepository = $reservationRepository;
        $this->encoderFactory = $encoderFactory;
        $this->shopRepository = $shopRepository;
    }

    /**
     * @Route("/%eccube_admin_route%/reservation/{id}/edit", requirements={"id" = "\d+"}, name="admin_reservation_edit")
     * @Template("@admin/Reservation/edit.twig")
     */
    public function index(Request $request, $id = null)
    {
        if (!$id) {
            throw new NotFoundHttpException();
        }

        $Reservation = $this->reservationRepository->find($id);
        $status = $Reservation->getStatus();

        if (is_null($Reservation)) {
            throw new NotFoundHttpException();
        }

        if(($this->getUser()->getAuthority()->getId() == 2)) {
            $Shop = $this->shopRepository->findOneBy(["memberId" => $this->getUser()->getId()]);
            $Reservation->setShopId($Shop->getId());
        }
        
        
        // 予約編集フォーム
        $builder = $this->formFactory->createBuilder(ReservationType::class, $Reservation);

        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getData()['status'] == 3 && $status != 3) {
                $Reservation->setCanceledAt(new \DateTime());

            } elseif ($form->getData()['status'] != 3) {
                $Reservation->setCanceledAt(null);
                $Reservation->setCanceledAtByUser(null);
            }
            
            $this->reservationRepository->save($Reservation);
            $this->addSuccess('admin.common.save_complete', 'admin');

            log_info('予約編集完了', [$Reservation->getId()]);
            $shop = $this->shopRepository->find($Reservation->getShopId());

            if ($Reservation->getStatus() == 3 && $status != 3) {
                // キャンセルの場合、 SMS送信
                $this->reservationRepository->twilioSet($shop->getTelephone(), $Reservation);
            }
            
            return $this->redirectToRoute('admin_reservation_edit', [
                'id' => $Reservation->getId(),
            ]);
        }

        return [
            'form' => $form->createView(),
            'Reservation' => $Reservation,
        ];
    }

   
   
}
