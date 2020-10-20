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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
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
        if (!$id) {
            throw new NotFoundHttpException();
        }

        $Shop = $this->shopRepository->find($id);

        if (is_null($Shop)) {
            throw new NotFoundHttpException();
        }

        if (($this->getUser()->getAuthority()->getId() == 2)) {
            if ($Shop->getMemberId() != $this->getUser()->getId()) {
                // todo
            }
        }

        // 会員登録フォーム
        $builder = $this->formFactory->createBuilder(ShopType::class, $Shop);

        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Shop $Shop */
            $Shop = $form->getData();

            // 画像の登録
            $logo = json_decode($Shop->getLogo(), true);
            if ($logo === null) {
                $logo = [];
            }

            $logo_images = $form->get('logo_add_images')->getData();
            foreach ($logo_images as $logo_image) {
                $logo[$logo_image] = ['sort' => ''];

                // 移動
                $file = new File($this->eccubeConfig['eccube_temp_image_dir'].'/'.$logo_image);
                $file->move($this->eccubeConfig['eccube_save_image_dir']);
            }

            // 画像の削除
            $delete_images = $form->get('logo_delete_images')->getData();
            foreach ($delete_images as $delete_image) {
                if (array_key_exists($delete_image, $logo)) {
                    unset($logo[$delete_image]);
                }

                // 削除
                $fs = new Filesystem();
                $fs->remove($this->eccubeConfig['eccube_save_image_dir'].'/'.$delete_image);
            }

            $sortNos = $request->get('sort_no_images');
            if ($sortNos) {
                foreach ($sortNos as $sortNo) {
                    list($filename, $sortNo_val) = explode('//', $sortNo);
                    $logo[$filename]['sort'] = $sortNo_val;
                }
            }

            $Shop->setLogo(json_encode($logo));

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

    /**
     * @Route("/%eccube_admin_route%/shop/image/add/{field_name}", name="admin_shop_image_add", methods={"POST"})
     */
    public function addLogoImage(Request $request, string $field_name)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new BadRequestHttpException();
        }

        $image = $request->files->get('admin_shop')[$field_name];

        $files = [];

        $allowExtensions = ['gif', 'jpg', 'jpeg', 'png'];

        //ファイルフォーマット検証
        $mimeType = $image->getMimeType();
        if (0 !== strpos($mimeType, 'image')) {
            throw new UnsupportedMediaTypeHttpException();
        }

        // 拡張子
        $extension = $image->getClientOriginalExtension();
        if (!in_array(strtolower($extension), $allowExtensions)) {
            throw new UnsupportedMediaTypeHttpException();
        }

        $filename = date('mdHis').uniqid('_').'.'.$extension;
        $image->move($this->eccubeConfig['eccube_temp_image_dir'], $filename);
        $files[] = $filename;

        return $this->json(['files' => $files], 200);
    }
}
