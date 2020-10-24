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
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

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
        
        // トップイメージ元ファイルを画面にセット
        $images = [];
        if (!is_null($Shop->getTopImages())) {
            $topImages = json_decode($Shop->getTopImages(), true);
            foreach ($topImages as $topImageFileName => $topImage) {
                $images[$topImage['sort']] = $topImageFileName;
            }
        }
        // ソート
        ksort($images);
        $form['images']->setData($images);

        // 店舗画像を画面にセット
        $intro_images = [];
        if (!is_null($Shop->getIntroductionImages())) {
            $introImages = json_decode($Shop->getIntroductionImages(), true);
            foreach ($introImages as $introImageFileName => $introImage) {
                $intro_images[$introImage['sort']] = $introImageFileName;
            }
        }
        // ソート
        ksort($intro_images);
        $form['intro_images']->setData($intro_images);
        // 元ファイル名を取得
        $originImages = [
            'logo' => $Shop->getLogo(),
            'commitmentImage1' => $Shop->getCommitmentImage1(),
            'commitmentImage2' => $Shop->getCommitmentImage2(),
            'environmentImage1' => $Shop->getEnvironmentImage1(),
            'environmentImage2' => $Shop->getEnvironmentImage2(),
            'environmentImage3' => $Shop->getEnvironmentImage3(),
            'messageImage' => $Shop->getMessageImage(),
        ];

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                /** @var Shop $Shop */
                $Shop = $form->getData();

                $files = [];
                $delete_images = [];
                $image_delete_flgs = [];

                // 画像
                $shopImages = $request->files->get('admin_shop');
                // 削除ありの場合
                if ($request->get('image_delete_flg') != '') {
                    $image_delete_flgs = explode(',', $request->get('image_delete_flg'));
                }
                // ファイルアップロードあり(単数の場合)
                if (count($shopImages) > 0) {
                    foreach ($shopImages as $key => $image) {
                        if (!is_null($image)) {
                            $extension = $this->checkFile($image);

                            $tmpFileName = date('mdHis').uniqid('_'). '.'. $extension;
                            // テンプファイル保存
                            $image->move($this->eccubeConfig['eccube_temp_image_dir'], $tmpFileName);
                            $files[$key] = $tmpFileName;
                            if ($key == 'logo') {
                                $Shop->setLogo($tmpFileName);
                            } elseif ($key == 'commitmentImage1') {
                                $Shop->setCommitmentImage1($tmpFileName);
                            } elseif ($key == 'commitmentImage2') {
                                $Shop->setCommitmentImage2($tmpFileName);
                            } elseif ($key == 'environmentImage1') {
                                $Shop->setEnvironmentImage1($tmpFileName);
                            } elseif ($key == 'environmentImage2') {
                                $Shop->setEnvironmentImage2($tmpFileName);
                            } elseif ($key == 'environmentImage3') {
                                $Shop->setEnvironmentImage3($tmpFileName);
                            } elseif ($key == 'messageImage') {
                                $Shop->setMessageImage($tmpFileName);
                            }
                            // 画像引き換えの場合
                            if (!is_null($originImages[$key]) && !in_array($key, $image_delete_flgs)) {
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
                if (in_array('logo', $image_delete_flgs) && !array_key_exists('logo', $files)) {
                    $Shop->setLogo(null);
                }
                if (in_array('commitmentImage1', $image_delete_flgs) && !array_key_exists('commitmentImage1', $files)) {
                    $Shop->setCommitmentImage1(null);
                } 
                if (in_array('commitmentImage2', $image_delete_flgs) && !array_key_exists('commitmentImage2', $files)) {
                    $Shop->setCommitmentImage2(null);
                }
                if (in_array('environmentImage1', $image_delete_flgs) && !array_key_exists('environmentImage1', $files)) {
                    $Shop->setEnvironmentImage1(null);
                }
                if (in_array('environmentImage2', $image_delete_flgs) && !array_key_exists('environmentImage2', $files)) {
                    $Shop->setEnvironmentImage2(null);
                }
                if (in_array('environmentImage3', $image_delete_flgs) && !array_key_exists('environmentImage3', $files)) {
                    $Shop->setEnvironmentImage3(null);
                }
                if (in_array('messageImage', $image_delete_flgs) && !array_key_exists('messageImage', $files)) {
                    $Shop->setMessageImage(null);
                }

                // トップイメージ画像の登録
                $top = json_decode($Shop->getTopImages(), true);
                if ($top === null) {
                    $top = [];
                }

                $top_images = $form->get('top_add_images')->getData();
                foreach ($top_images as $top_image) {
                    $top[$top_image] = ['sort' => ''];

                    // 移動
                    $this->saveFile($top_image);
                }

                // トップイメージ画像の削除
                $top_delete_images = $form->get('top_delete_images')->getData();
                foreach ($top_delete_images as $top_delete_image) {
                    if (array_key_exists($top_delete_image, $top)) {
                        unset($top[$top_delete_image]);
                    }
                    $this->deleteFile($top_delete_image);
                }
                

                // 店舗画像の登録
                $intro = json_decode($Shop->getIntroductionImages(), true);
                if ($intro === null) {
                    $intro = [];
                }

                $intro_add_images = $form->get('intro_add_images')->getData();
                foreach ($intro_add_images as $intro_add_image) {
                    $intro[$intro_add_image] = ['sort' => ''];

                    // 移動
                    $this->saveFile($intro_add_image);
                }

                // 店舗画像の削除
                $intro_delete_images = $form->get('intro_delete_images')->getData();
                foreach ($intro_delete_images as $intro_delete_image) {
                    if (array_key_exists($intro_delete_image, $intro)) {
                        unset($intro[$intro_delete_image]);
                    }
                    $this->deleteFile($intro_delete_image);
                }
                
                // 画像ソート順
                $sortNos = $request->get('sort_no_images');
                if ($sortNos) {
                    foreach ($sortNos as $sortNo) {
                        list($filename, $sortNo_val) = explode('//', $sortNo);
                        if (array_key_exists($filename, $top)) $top[$filename]['sort'] = $sortNo_val;
                        if (array_key_exists($filename, $intro)) $intro[$filename]['sort'] = $sortNo_val;
                    }
                }
                
                $Shop->setTopImages($top != [] ? json_encode($top) : null);
                $Shop->setIntroductionImages($intro != [] ? json_encode($intro) : null);

                $this->entityManager->persist($Shop);
                $this->entityManager->flush();

                log_info('掲載店変更完了', [$Shop->getId()]);

                $this->addSuccess('admin.common.save_complete', 'admin');

                // テンプファイル移動
                foreach ($files as $filename) {
                    $this->saveFile($filename);
                }

                // ファイル削除
                foreach ($delete_images as $delete_image) {
                    $this->deleteFile($delete_image);
                }

                return $this->redirectToRoute('admin_shop_edit', [
                    'id' => $Shop->getId(),
                ]);
            }
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

        $extension = $this->checkFile($image);

        $filename = date('mdHis').uniqid('_').'.'.$extension;
        $image->move($this->eccubeConfig['eccube_temp_image_dir'], $filename);
        $files[] = $filename;

        return $this->json(['files' => $files], 200);
    }

    /**
     * tempファイルを移動
     * $fileName：ファイル名
     */
    public function saveFile($fileName)
    {
        $file = new File($this->eccubeConfig['eccube_temp_image_dir']. '/'. $fileName);
        $file->move($this->eccubeConfig['eccube_save_image_dir']);
    }

    /**
     * ファイルを削除
     * $fileName：ファイル名
     */
    public function deleteFile($fileName)
    {
        $fs = new Filesystem();
        $fs->remove($this->eccubeConfig['eccube_save_image_dir']. '/'. $fileName);
    }

    /**
     * ファイルチェック
     * $image：ファイル
     */
    public function checkFile($image)
    {
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

        return $extension;
    }

    
}
