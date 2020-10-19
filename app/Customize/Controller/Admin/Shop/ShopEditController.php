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

namespace Customize\Controller\Admin\Shop;

use Customize\Entity\Shop;
use Customize\Form\Type\Admin\ShopType;
use Customize\Repository\ShopRepository;
use Eccube\Controller\AbstractController;
use Eccube\Entity\Master\CustomerStatus;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Form\Type\Admin\CustomerType;
use Eccube\Repository\CustomerRepository;
use Eccube\Util\StringUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;


class ShopEditController extends AbstractController
{

    protected $shopRepository;

    /**
     * @var EncoderFactoryInterface
     */
    protected $encoderFactory;

    public function __construct(
        ShopRepository $shopRepository,
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->shopRepository = $shopRepository;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @Route("/%eccube_admin_route%/shop/{id}/edit", requirements={"id" = "\d+"}, name="admin_shop_edit")
     * @Template("@admin/Shop/edit.twig")
     */
    public function index(Request $request, $id = null)
    {

        // 編集
        if ($id) {
            $Shop = $this->shopRepository->find($id);

            if (is_null($Shop)) {
                throw new NotFoundHttpException();
            }

	        if(($this->getUser()->getAuthority()->getId() == 2)) {
		        if($Shop->getMemberId() != $this->getUser()->getId()) {
			        throw new NotFoundHttpException();
		        }
	        }

        // 新規登録なし
        } else {
	        throw new NotFoundHttpException();
        }

        // 会員登録フォーム
        $builder = $this->formFactory->createBuilder(ShopType::class, $Shop);

        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        	$Shop = $form->getData();

            $this->entityManager->persist($Shop);
            $this->entityManager->flush();

            log_info('掲載店変更完了', [$Shop->getId()]);


            $this->addSuccess('admin.common.save_complete', 'admin');

            return $this->redirectToRoute('admin_shop_edit', [
                'id' => $Shop->getId(),
            ]);
        }

        return [
            'form' => $form->createView(),
            'Shop' => $Shop,
        ];
    }
}
