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
use Customize\Repository\StaffRepository;
use Eccube\Controller\AbstractController;
use Eccube\Entity\Master\CustomerStatus;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Form\Type\Admin\CustomerType;
use Eccube\Repository\CustomerRepository;
use Eccube\Util\StringUtil;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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

    public function __construct(
        StaffRepository $staffRepository,
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->staffRepository = $staffRepository;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @Route("/%eccube_admin_route%/staff/{id}/edit", requirements={"id" = "\d+"}, name="admin_staff_edit")
     * @Route("/%eccube_admin_route%/staff/new", name="admin_staff_new")
     * @Template("@admin/Staff/news_edit.twig")
     */
    public function index(Request $request, $id = null)
    {
        $delete_images = [];
        // 編集
        if ($id) {
            $Staff = $this->staffRepository->find($id);
            
            // 削除されたファイル名を取得
            if ($request->get('image_delete_flg') != '') {
                $image_delete_flgs = explode(',', $request->get('image_delete_flg'));
                if (in_array('image', $image_delete_flgs)) {
                    $delete_images[] = $Staff->getImage();
                    $Staff->setImage(null);
                } 
                if (in_array('image1', $image_delete_flgs)) {
                    $delete_images[] = $Staff->getImage1();
                    $Staff->setImage1(null);
                }
                if (in_array('image2', $image_delete_flgs)) {
                    $delete_images[] = $Staff->getImage2();
                    $Staff->setImage2(null);
                }
                if (in_array('image3', $image_delete_flgs)) {
                    $delete_images[] = $Staff->getImage3();
                    $Staff->setImage3(null);
                }
                if (in_array('image4', $image_delete_flgs)) {
                    $delete_images[] = $Staff->getImage4();
                    $Staff->setImage4(null);
                }
            }

            if (is_null($Staff)) {
                throw new NotFoundHttpException();
            }

        // 新規登録
        } else {
            $Staff = new Staff();
            $Staff->setCreateDate(new \DateTime());
            // TODO shop ID
            $Staff->setShopId(20);
        }
        
        // スタッフ登録フォーム
        $builder = $this->formFactory->createBuilder(StaffType::class, $Staff);

        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $Staff = $form->getData();
            // 画像
            $images = $request->files->get('admin_staff');
            $allowExtensions = ['gif', 'jpg', 'jpeg', 'png'];
            $files = [];
            
            if (count($images) > 0) {
                foreach ($images as $key => $image) {
                    if (!is_null($image)) {
                        // 拡張子
                        $extension = $image->getClientOriginalExtension();
                        if (!in_array(strtolower($extension), $allowExtensions)) {
                            throw new UnsupportedMediaTypeHttpException();
                        }

                        $tmpFileName = date('mdHis').uniqid('_'). '.'. $extension;
                        // テンプファイル保存
                        $image->move($this->eccubeConfig['eccube_temp_image_dir'], $tmpFileName);
                        $files[] = $tmpFileName;
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
                    }
                }
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
