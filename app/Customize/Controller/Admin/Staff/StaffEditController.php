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

namespace Customize\Controller\Admin\Staff;

use Customize\Entity\Staff;
use Customize\Form\Type\Admin\StaffType;
use Customize\Repository\ShopRepository;
use Customize\Repository\StaffRepository;
use Eccube\Controller\AbstractController;
use Eccube\Entity\Member;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Filesystem\Filesystem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;


class StaffEditController extends AbstractController
{
    protected $staffRepository;

    /**
     * @var EncoderFactoryInterface
     */
    protected $encoderFactory;
    protected $shopRepository;

    public function __construct(
        StaffRepository $staffRepository,
        EncoderFactoryInterface $encoderFactory,
		ShopRepository $shopRepository
    ) {
        $this->staffRepository = $staffRepository;
        $this->encoderFactory = $encoderFactory;
        $this->shopRepository = $shopRepository;
    }

    /**
     * @Route("/%eccube_admin_route%/staff/{id}/edit", requirements={"id" = "\d+"}, name="admin_staff_edit")
     * @Route("/%eccube_admin_route%/staff/new", name="admin_staff_new")
     * @Template("@admin/Staff/news_edit.twig")
     */
    public function index(Request $request, $id = null)
    {
        // 編集
        if ($id) {
            $Staff = $this->staffRepository->find($id);
            // 元ファイル名を取得
            $originImages = [
                'image' => $Staff->getImage(),
                'image1' => $Staff->getImage1(),
                'image2' => $Staff->getImage2(),
                'image3' => $Staff->getImage3(),
                'image4' => $Staff->getImage4(),
            ];

            if (is_null($Staff)) {
                throw new NotFoundHttpException();
            }

        // 新規登録
        } else {
            $Staff = new Staff();
            $Staff->setCreateDate(new \DateTime());


            if(($this->getUser()->getAuthority()->getId() == 2)) {

            	$Shop = $this->shopRepository->findOneBy(["memberId" => $this->getUser()->getId()]);
	            $Staff->setShopId($Shop->getId());
            }

        }
        
        // スタッフ登録フォーム
        $builder = $this->formFactory->createBuilder(StaffType::class, $Staff);

        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $files = [];
            $delete_images = [];
            $image_delete_flgs = [];
            $Staff = $form->getData();
            // 画像
            $images = $request->files->get('admin_staff');
            $allowExtensions = ['gif', 'jpg', 'jpeg', 'png'];
            
            // 削除ありの場合
            if ($request->get('image_delete_flg') != '') {
                $image_delete_flgs = explode(',', $request->get('image_delete_flg'));
            }
            // ファイルアップロードあり
            if (count($images) > 0) {
                foreach ($images as $key => $image) {
                    if (!is_null($image)) {
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

                        $tmpFileName = date('mdHis').uniqid('_'). '.'. $extension;
                        // テンプファイル保存
                        $image->move($this->eccubeConfig['eccube_temp_image_dir'], $tmpFileName);
                        $files[$key] = $tmpFileName;
                        if ($key == 'image') {
                            $Staff->setImage($tmpFileName);
                        } elseif ($key == 'image1') {
                            $Staff->setImage1($tmpFileName);
                        } elseif ($key == 'image2') {
                            $Staff->setImage2($tmpFileName);
                        } elseif ($key == 'image3') {
                            $Staff->setImage3($tmpFileName);
                        } elseif ($key == 'image4') {
                            $Staff->setImage4($tmpFileName);
                        }
                        // 画像引き換えの場合
                        if ($id && !is_null($originImages[$key]) && !in_array($key, $image_delete_flgs)) {
                            $delete_images[] = $originImages[$key];
                        }
                    }
                }
            }

            // 削除されたファイル名を取得
            foreach ($image_delete_flgs as $image_delete_flg) {
                $delete_images[] = $originImages[$image_delete_flg];
            }
            // 削除あり&アップロードなしの場合、null設定
            if (in_array('image', $image_delete_flgs) && !array_key_exists('image', $files)) {
                $Staff->setImage(null);
            } 
            if (in_array('image1', $image_delete_flgs) && !array_key_exists('image1', $files)) {
                $Staff->setImage1(null);
            }
            if (in_array('image2', $image_delete_flgs) && !array_key_exists('image2', $files)) {
                $Staff->setImage2(null);
            }
            if (in_array('image3', $image_delete_flgs) && !array_key_exists('image3', $files)) {
                $Staff->setImage3(null);
            }
            if (in_array('image4', $image_delete_flgs) && !array_key_exists('image4', $files)) {
                $Staff->setImage4(null);
            }
            
            $this->staffRepository->save($Staff);
            $this->addSuccess('admin.common.save_complete', 'admin');

            log_info('スタッフ登録完了', [$Staff->getId()]);
            // テンプファイル移動
            foreach ($files as $filename) {
                $file = new File($this->eccubeConfig['eccube_temp_image_dir']. '/'. $filename);
                $file->move($this->eccubeConfig['eccube_save_image_dir']);
            }

            // ファイル削除
            foreach ($delete_images as $delete_image) {
                $fileDelete = new Filesystem();
                $fileDelete->remove($this->eccubeConfig['eccube_save_image_dir']. '/'. $delete_image);
            }
            
            return $this->redirectToRoute('admin_staff_edit', [
                'id' => $Staff->getId(),
            ]);
        }

        return [
            'form' => $form->createView(),
            'Staff' => $Staff,
        ];
    }

   
   
}
