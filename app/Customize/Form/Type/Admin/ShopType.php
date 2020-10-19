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
use Eccube\Entity\Customer;
use Eccube\Form\Type\AddressType;
use Eccube\Form\Type\KanaType;
use Eccube\Form\Type\Master\CustomerStatusType;
use Eccube\Form\Type\Master\JobType;
use Eccube\Form\Type\Master\SexType;
use Eccube\Form\Type\NameType;
use Eccube\Form\Type\RepeatedPasswordType;
use Eccube\Form\Type\PhoneNumberType;
use Eccube\Form\Type\PostalType;
use Eccube\Form\Validator\Email;
use Eccube\Repository\Master\PrefRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ShopType extends AbstractType
{
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;
    protected $prefRepository;

    private $pref_choices = array();

    /**
     * CustomerType constructor.
     *
     * @param EccubeConfig $eccubeConfig
     */
    public function __construct(
    	EccubeConfig $eccubeConfig,
		PrefRepository $prefRepository
    )
    {
        $this->eccubeConfig = $eccubeConfig;
        $this->prefRepository = $prefRepository;

        $prefs = $this->prefRepository->findAll();

        if(count($prefs) > 0) {
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
	            "constraints" => [
	            	new Assert\NotBlank(
	            		[
				            "message" => "店舗名を入れてください。"
			            ]
		            )
	            ]
            ])
	        ->add("sub_name", TextType::class, [
	        	"required" => false
	        ])
	        ->add("person_in_charge", TextType::class, [
		        'required' => true,
		        "constraints" => [
			        new Assert\NotBlank(
				        [
					        "message" => "担当者を入れてください。"
				        ]
			        )
		        ]
	        ])
	        ->add("industry_type", ChoiceType::class, [
		        "choices" => [
			        "ヘアサロン" => 1,
			        "ネイル・まつげサロン" => 2,
			        "リラクスサロン" => 3,
			        "エステサロン" => 4,
			        "その他" => 5,
		        ],
		        "expanded" => false,
		        "multiple" => false,
		        "required" => true,
	        ])

	        ->add("post_code", TextType::class, [
		        'required' => true,
		        "constraints" => [
			        new Assert\NotBlank(
				        [
					        "message" => "郵便番号を入れてください。"
				        ]
			        )
		        ]
	        ])
	        ->add("mtb_pref_id", ChoiceType::class, [
		        "choices" => $this->pref_choices,
		        "expanded" => false,
		        "multiple" => false,
		        "required" => true,
	        ])
	        ->add("address", TextType::class, [
		        'required' => true,
		        "constraints" => [
			        new Assert\NotBlank(
				        [
					        "message" => "住所を入れてください。"
				        ]
			        )
		        ]
	        ])
	        ->add("telephone", PhoneNumberType::class, [
		        'required' => true,
		        "constraints" => [
			        new Assert\NotBlank(
				        [
					        "message" => "電話番号を入れてください。"
				        ]
			        )
		        ]
	        ])
	        ->add("email", EmailType::class, [
		        'required' => true,
		        "constraints" => [
			        new Assert\NotBlank(
				        [
					        "message" => "メールアドレスを入れてください。"
				        ]
			        )
		        ]
	        ])

	        ->add("url", UrlType::class, [
		        'required' => false,
	        ])

	        ->add('logo', FileType::class, [
		        'multiple' => false,
		        'required' => false,
		        'mapped' => false,
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


	        ->add("access", TextareaType::class)
	        ->add("credit_cards_info", TextareaType::class)
	        ->add("price", TextareaType::class)
	        ->add("seats", TextareaType::class)
	        ->add("staff_number", TextareaType::class)
	        ->add("parking_area", TextareaType::class)
	        ->add("conditions", TextareaType::class)






//            ->add('kana', KanaType::class, [
//                'required' => true,
//            ])
//            ->add('company_name', TextType::class, [
//                'required' => false,
//                'constraints' => [
//                    new Assert\Length([
//                        'max' => $this->eccubeConfig['eccube_stext_len'],
//                    ]),
//                ],
//            ])
//            ->add('postal_code', PostalType::class, [
//                'required' => true,
//            ])
//            ->add('address', AddressType::class, [
//                'required' => true,
//            ])
//            ->add('phone_number', PhoneNumberType::class, [
//                'required' => true,
//            ])
//            ->add('email', EmailType::class, [
//                'required' => true,
//                'constraints' => [
//                    new Assert\NotBlank(),
//                    new Email(['strict' => $this->eccubeConfig['eccube_rfc_email_check']]),
//                ],
//                'attr' => [
//                    'placeholder' => 'common.mail_address_sample',
//                ],
//            ])
//            ->add('sex', SexType::class, [
//                'required' => false,
//            ])
//            ->add('job', JobType::class, [
//                'required' => false,
//            ])
//            ->add('birth', BirthdayType::class, [
//                'required' => false,
//                'input' => 'datetime',
//                'years' => range(date('Y'), date('Y') - $this->eccubeConfig['eccube_birth_max']),
//                'widget' => 'single_text',
//                'format' => 'yyyy-MM-dd',
//                'placeholder' => ['year' => '----', 'month' => '--', 'day' => '--'],
//                'constraints' => [
//                    new Assert\LessThanOrEqual([
//                        'value' => date('Y-m-d', strtotime('-1 day')),
//                        'message' => 'form_error.select_is_future_or_now_date',
//                    ]),
//                ],
//            ])
//            ->add('password', RepeatedPasswordType::class, [
//                // 'type' => 'password',
//                'first_options' => [
//                    'label' => 'member.label.pass',
//                ],
//                'second_options' => [
//                    'label' => 'member.label.verify_pass',
//                ],
//            ])
//            ->add('status', CustomerStatusType::class, [
//                'required' => true,
//                'constraints' => [
//                    new Assert\NotBlank(),
//                ],
//            ])
//            ->add(
//                'point',
//                NumberType::class,
//                [
//                    'required' => false,
//                    'constraints' => [
//                        new Assert\Regex([
//                            'pattern' => "/^\d+$/u",
//                            'message' => 'form_error.numeric_only',
//                        ]),
//                    ],
//                ]
//            )
            ->add('memo', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_ltext_len'],
                    ]),
                ],
            ]);

//        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
//            $form = $event->getForm();
//            /** @var Customer $Customer */
//            $Customer = $event->getData();
//            if ($Customer->getPassword() != '' && $Customer->getPassword() == $Customer->getEmail()) {
//                $form['password']['first']->addError(new FormError(trans('common.password_eq_email')));
//            }
//        });
//
//        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
//            $Customer = $event->getData();
//
//            // ポイント数が入力されていない場合0を登録
//            if (is_null($Customer->getPoint())) {
//                $Customer->setPoint(0);
//            }
//        });
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
