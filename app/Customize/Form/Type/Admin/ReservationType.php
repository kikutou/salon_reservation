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

namespace Customize\Form\Type\Admin;

use Eccube\Common\EccubeConfig;
use Symfony\Component\Form\AbstractType;
use Customize\Repository\MenuRepository;
use Customize\Repository\StaffRepository;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ReservationType extends AbstractType
{

    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;
    protected $menuRepository;
    protected $staffRepository;
    private $menu_choices = [];
    private $staff_choices = [];

    /**
     * CustomerType constructor.
     *
     * @param EccubeConfig $eccubeConfig
     */
    public function __construct(
        EccubeConfig $eccubeConfig,
        MenuRepository $menuRepository,
        StaffRepository $staffRepository
    ){
        $this->eccubeConfig = $eccubeConfig;
        $this->menuRepository = $menuRepository;
        $this->staffRepository = $staffRepository;

        $menus = $this->menuRepository->findAll();
        $staffs = $this->staffRepository->findAll();

        if (count($menus) > 0) {
            foreach ($menus as $menu) {
                $this->menu_choices[$menu->getshopId()][] = [$menu->getId(), $menu->getTitle()];
            }
        }
        if (count($staffs) > 0) {
            foreach ($staffs as $staff) {
                $this->staff_choices[$staff->getshopId()][] = [$staff->getId(), $staff->getName()];
            }
        }
    

    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $shop_menus = [];
        $shop_staffs = [];
        if (!is_null($options['data']['shopId'])) {
            if (array_key_exists($options['data']['shopId'], $this->menu_choices)) {
                foreach($this->menu_choices[$options['data']['shopId']] as $key => $menu) {
                    $shop_menus[$menu[1]] = $menu[0];
                }
            }
            if (array_key_exists($options['data']['shopId'], $this->staff_choices)) {
                foreach($this->staff_choices[$options['data']['shopId']] as $key => $staff) {
                    $shop_staffs[$staff[1]] = $staff[0];
                }
            }
        }
        $builder
            ->add('menu_id', ChoiceType::class, [
                'choices' => $shop_menus,
                'expanded' => false,
                'multiple' => false,
                'required' => false,
            ])
            ->add('staff_id', ChoiceType::class, [
                'choices' => $shop_staffs,
                'expanded' => false,
                'multiple' => false,
                'required' => false,
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    '予約済み' => 2,
                    'キャンセル' => 3,
                    '受付済み' => 4,
                ],
                'expanded' => false,
                'multiple' => false,
                'required' => true,
            ])
            ->add('message_sended_at', DateTimeType::class, [
                'label' => '店舗に通知時間',
                'required' => false,
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd HH:mm',
                'attr' => [
                    'class' => 'datetimepicker-input',
                    'data-target' => '#'.$this->getBlockPrefix().'_message_sended_at',
                    'data-toggle' => 'datetimepicker',
                ],
            ])
            ->add('note', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_ltext_len'],
                    ]),
                ],
            ])
            ->add('memo_admin', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_ltext_len'],
                    ]),
                ],
            ])
            ->add('message_to_shop', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_ltext_len'],
                    ]),
                ],
            ])
            ->add('message_sended_status', ChoiceType::class, [
                'choices' => [
                    '未通知' => 1,
                    '通知済み' => 2,
                    '通知失敗' => 3,
                ],
                'expanded' => false,
                'multiple' => false,
                'required' => true,
            ])
            ->add(
                'point',
                NumberType::class,
                [
                    'required' => false,
                    'constraints' => [
                        new Assert\Regex([
                            'pattern' => "/^\d+$/u",
                            'message' => 'form_error.numeric_only',
                        ]),
                    ],
                ]
            )
            ->add(
                'point_sum_before_reservation',
                NumberType::class,
                [
                    'required' => false,
                    'constraints' => [
                        new Assert\Regex([
                            'pattern' => "/^\d+$/u",
                            'message' => 'form_error.numeric_only',
                        ]),
                    ],
                ]
            )
            ->add('created_at', DateTimeType::class, [
                'label' => '予約時間',
                'required' => false,
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd HH:mm',
                'attr' => [
                    'class' => 'datetimepicker-input',
                    'data-target' => '#'.$this->getBlockPrefix().'_created_at',
                    'data-toggle' => 'datetimepicker',
                ],
            ])
            ->add('memo', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_ltext_len'],
                    ]),
                ],
            ]);

	}
	

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Customize\Entity\Reservation',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_reservation';
    }
}
