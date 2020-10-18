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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Eccube\Repository\Master\PrefRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class StaffType extends AbstractType
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
	            'constraints' => [
	            	new Assert\NotBlank(
	            		[
				            'message' => '名前を入れてください。'
						]),
					new Assert\Length([
						'max' => $this->eccubeConfig['eccube_ltext_len'],
					])
					
	            ]
            ])
            ->add('image', FileType::class, [
                'multiple' => false,
                'required' => false,
				'mapped' => false,
				'constraints' => [
	            	new File([
						'maxSize' => '20m',
					])
	            ]
				
            ])
            ->add('title', TextType::class, [
				'required' => false,
				'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_ltext_len'],
                    ]),
                ],
            ])
            ->add('introduction', TextType::class, [
				'required' => false,
				'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_ltext_len'],
                    ]),
                ],
            ])
            ->add('experience', TextType::class, [
				'required' => false,
				'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_ltext_len'],
                    ]),
                ],
            ])
            ->add('style', TextType::class, [
				'required' => false,
				'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_ltext_len'],
                    ]),
                ],
            ])
            ->add('skills', TextType::class, [
				'required' => false,
				'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_ltext_len'],
                    ]),
                ],
            ])
            ->add('hobbies', TextType::class, [
				'required' => false,
				'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_ltext_len'],
                    ]),
                ],
			])
			->add('image1', FileType::class, [
                'multiple' => false,
                'required' => false,
				'mapped' => false,
				'constraints' => [
	            	new File([
						'maxSize' => '20m',
					])
	            ]
				
			])
			->add('image2', FileType::class, [
                'multiple' => false,
                'required' => false,
				'mapped' => false,
				'constraints' => [
	            	new File([
						'maxSize' => '20m',
					])
	            ]
				
			])
			->add('image3', FileType::class, [
                'multiple' => false,
                'required' => false,
				'mapped' => false,
				'constraints' => [
	            	new File([
						'maxSize' => '20m',
					])
	            ]
				
			])
			->add('image4', FileType::class, [
                'multiple' => false,
                'required' => false,
				'mapped' => false,
				'constraints' => [
	            	new File([
						'maxSize' => '20m',
					])
	            ]
				
			])
			->add('comment1', TextType::class, [
				'required' => false,
				'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_ltext_len'],
                    ]),
                ],
			])
			->add('comment2', TextType::class, [
				'required' => false,
				'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_ltext_len'],
                    ]),
                ],
			])
			->add('comment3', TextType::class, [
				'required' => false,
				'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_ltext_len'],
                    ]),
                ],
			])
			->add('comment4', TextType::class, [
				'required' => false,
				'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_ltext_len'],
                    ]),
                ],
			])
			->add('businessHours', TextType::class, [
				'required' => false,
				'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_ltext_len'],
                    ]),
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
            'data_class' => 'Customize\Entity\Staff',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_staff';
    }
}
