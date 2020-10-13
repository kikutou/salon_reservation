<?php


namespace Customize\Form\Type\Front;

use Customize\Repository\ShopRepository;
use Eccube\Common\EccubeConfig;
use Eccube\Entity\Customer;
use Eccube\Form\Type\AddressType;
use Eccube\Form\Type\KanaType;
use Eccube\Form\Type\Master\JobType;
use Eccube\Form\Type\Master\SexType;
use Eccube\Form\Type\NameType;
use Eccube\Form\Type\RepeatedEmailType;
use Eccube\Form\Type\RepeatedPasswordType;
use Eccube\Form\Type\PhoneNumberType;
use Eccube\Form\Type\PostalType;
use Eccube\Repository\MemberRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class ShopEntryType extends AbstractType
{
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    protected $shopRepository;

    /**
     * EntryType constructor.
     *
     * @param EccubeConfig $eccubeConfig
     */
    public function __construct(EccubeConfig $eccubeConfig, ShopRepository $shopRepository)
    {
        $this->eccubeConfig = $eccubeConfig;
        $this->shopRepository = $shopRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add("open_status", ChoiceType::class, [
	        	"choices" => [
					"開業済み" => 1,
			        "開業予定" => 2
		        ],
		        "expanded" => false,
		        "multiple" => false,
		        "required" => true,
		        'constraints' => [
		        	new Assert\NotBlank(["message" => "開業状況を選択してください。"]),
		        ],
	        ])
            ->add('name', TextType::class, [
                'required' => true,
	            'constraints' => [
		            new Assert\NotBlank(["message" => "貴店名を入力してください。"]),
	            ],
            ])
	        ->add("person_in_charge", TextType::class, [
	        	"required" => true,
		        'constraints' => [
			        new Assert\NotBlank(["message" => "ご担当者を入力してください。"]),
		        ],
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



            ->add('postal_code', PostalType::class, [
            	"required" => true
            ])
            ->add('address', AddressType::class, [
            	"required" => true
            ])

            ->add('phone_number', PhoneNumberType::class, [
                'required' => true,
            ])
            ->add('email', RepeatedEmailType::class)
            ->add('password', RepeatedPasswordType::class)

	        ->add("url", UrlType::class)
	        ->add("question", TextareaType::class);


//        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
//            $Customer = $event->getData();
//            if ($Customer instanceof Customer && !$Customer->getId()) {
//                $form = $event->getForm();
//
//                $form->add('user_policy_check', CheckboxType::class, [
//                        'required' => true,
//                        'label' => null,
//                        'mapped' => false,
//                        'constraints' => [
//                            new Assert\NotBlank(),
//                        ],
//                    ]);
//            }
//        }
//        );

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            /** @var Customer $Customer */
            $data = $event->getData();

            if($data["email"] != "" && count($this->shopRepository->findBy(["email"=>$data["email"]])) > 0) {
	            $form['email']['first']->addError(new FormError("該当メールアドレスはすでに登録済みです。"));
            }

	        if(
	        	$data["phone_number"] != ""
		        && count($this->shopRepository->findBy(["telephone"=>$data["phone_number"]])) > 0
	        ) {
		        $form['phone_number']->addError(new FormError("該当電話番号はすでに登録済みです。"));
	        }

        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'shop_entry';
    }
}
