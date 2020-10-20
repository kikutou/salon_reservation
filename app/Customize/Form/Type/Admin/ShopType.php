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
use Eccube\Form\Type\PhoneNumberType;
use Eccube\Repository\Master\PrefRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ShopType extends AbstractType
{
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;
    protected $prefRepository;

    private $pref_choices = [];

    /**
     * CustomerType constructor.
     */
    public function __construct(
        EccubeConfig $eccubeConfig,
        PrefRepository $prefRepository
    ) {
        $this->eccubeConfig = $eccubeConfig;
        $this->prefRepository = $prefRepository;

        $prefs = $this->prefRepository->findAll();

        if (count($prefs) > 0) {
            foreach ($prefs as $pref) {
                $this->pref_choices[$pref->getName()] = $pref->getId();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(
                        [
                            'message' => '店舗名を入れてください。',
                        ]
                    ),
                ],
            ])
            ->add('sub_name', TextType::class, [
                'required' => false,
            ])
            ->add('person_in_charge', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(
                        [
                            'message' => '担当者を入れてください。',
                        ]
                    ),
                ],
            ])
            ->add('industry_type', ChoiceType::class, [
                'choices' => [
                    'ヘアサロン' => 1,
                    'ネイル・まつげサロン' => 2,
                    'リラクスサロン' => 3,
                    'エステサロン' => 4,
                    'その他' => 5,
                ],
                'expanded' => false,
                'multiple' => false,
                'required' => true,
            ])

            ->add('post_code', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(
                        [
                            'message' => '郵便番号を入れてください。',
                        ]
                    ),
                ],
            ])
            ->add('mtb_pref_id', ChoiceType::class, [
                'choices' => $this->pref_choices,
                'expanded' => false,
                'multiple' => false,
                'required' => true,
            ])
            ->add('address', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(
                        [
                            'message' => '住所を入れてください。',
                        ]
                    ),
                ],
            ])
            ->add('telephone', PhoneNumberType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(
                        [
                            'message' => '電話番号を入れてください。',
                        ]
                    ),
                ],
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(
                        [
                            'message' => 'メールアドレスを入れてください。',
                        ]
                    ),
                ],
            ])

            ->add('url', UrlType::class, [
                'required' => false,
            ])

            ->add('logo', FileType::class, [
                'multiple' => false,
                'required' => false,
                'mapped' => false,
            ])
            // 画像
            ->add('images', CollectionType::class, [
                'entry_type' => HiddenType::class,
                'prototype' => true,
                'mapped' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('logo_add_images', CollectionType::class, [
                'entry_type' => HiddenType::class,
                'prototype' => true,
                'mapped' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('logo_delete_images', CollectionType::class, [
                'entry_type' => HiddenType::class,
                'prototype' => true,
                'mapped' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ])

            ->add('access', TextareaType::class)
            ->add('credit_cards_info', TextareaType::class)
            ->add('price', TextareaType::class)
            ->add('seats', TextareaType::class)
            ->add('staff_number', TextareaType::class)
            ->add('parking_area', TextareaType::class)
            ->add('conditions', TextareaType::class)

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
            'data_class' => 'Customize\Entity\Shop',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_shop';
    }
}
