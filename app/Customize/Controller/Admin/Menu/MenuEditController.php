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

namespace Customize\Controller\Admin\Menu;

use Customize\Entity\Menu;
use Customize\Form\Type\Admin\MenuType;
use Customize\Repository\ShopRepository;
use Customize\Repository\MenuRepository;
use Eccube\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;


class MenuEditController extends AbstractController
{
    protected $menuRepository;

    /**
     * @var EncoderFactoryInterface
     */
    protected $encoderFactory;
    protected $shopRepository;

    public function __construct(
        MenuRepository $menuRepository,
        EncoderFactoryInterface $encoderFactory,
		ShopRepository $shopRepository
    ) {
        $this->menuRepository = $menuRepository;
        $this->encoderFactory = $encoderFactory;
        $this->shopRepository = $shopRepository;
    }

    /**
     * @Route("/%eccube_admin_route%/menu/{id}/edit", requirements={"id" = "\d+"}, name="admin_menu_edit")
     * @Route("/%eccube_admin_route%/menu/new", name="admin_menu_new")
     * @Template("@admin/Menu/news_edit.twig")
     */
    public function index(Request $request, $id = null)
    {
        // 編集
        if ($id) {
            $Menu = $this->menuRepository->find($id);
            
            if (is_null($Menu)) {
                throw new NotFoundHttpException();
            }

        // 新規登録
        } else {
            $Menu = new Menu();
            $Menu->setCreateDate(new \DateTime());

            if(($this->getUser()->getAuthority()->getId() == 2)) {
            	$Shop = $this->shopRepository->findOneBy(["memberId" => $this->getUser()->getId()]);
	            $Menu->setShopId($Shop->getId());
            }
        }
        
        // メニュー登録フォーム
        $builder = $this->formFactory->createBuilder(MenuType::class, $Menu);

        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->menuRepository->save($Menu);
            $this->addSuccess('admin.common.save_complete', 'admin');

            log_info('メニュー登録完了', [$Menu->getId()]);
            
            return $this->redirectToRoute('admin_menu_edit', [
                'id' => $Menu->getId(),
            ]);
        }

        return [
            'form' => $form->createView(),
            'Menu' => $Menu,
        ];
    }

   
   
}
