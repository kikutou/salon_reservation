<?php

namespace Customize\Controller;

use Customize\Entity\Shop;
use Customize\Form\Type\Front\ShopEntryType;
use Customize\Repository\ShopRepository;
use Eccube\Controller\AbstractController;
use Eccube\Entity\Member;
use Eccube\Repository\Master\AuthorityRepository;
use Eccube\Repository\Master\WorkRepository;
use Eccube\Repository\MemberRepository;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class ShopController extends AbstractController
{

	/**
	 * @var ShopRepository
	 */
	protected $shopRepository;

	/**
	 * @var EncoderFactoryInterface
	 */
	protected $encoderFactory;

	protected $authorityRepository;
	protected $workRepository;
	protected $memberRepository;


	public function __construct(
		ShopRepository $shopRepository,
		EncoderFactoryInterface $encoderFactory,
		AuthorityRepository $authorityRepository,
		WorkRepository $workRepository,
		MemberRepository $memberRepository
	) {
		$this->shopRepository = $shopRepository;
		$this->encoderFactory = $encoderFactory;
		$this->authorityRepository = $authorityRepository;
		$this->workRepository = $workRepository;
		$this->memberRepository = $memberRepository;
	}

	/**
	 * @Route("/shop/entry")
	 * @Template("Shop/entry.twig")
	 */
	public function entry(Request $request)
	{

		/* @var $builder \Symfony\Component\Form\FormBuilderInterface */
		$builder = $this->formFactory->createBuilder(ShopEntryType::class);
		$form = $builder->getForm();

		if($request->getMethod() == "POST") {
			$form->handleRequest($request);

			if ($form->isSubmitted() && $form->isValid()) {

				$form_data = $form->getData();

				$Member = new Member();

				$salt = $Member->getSalt();
				$encoder = $this->encoderFactory->getEncoder($Member);
				if (empty($salt)) {
					$salt = $encoder->createSalt();
				}

				$password = $encoder->encodePassword($form_data["password"], $salt);
				$Member
					->setPassword($password)
					->setSalt($salt)
					->setLoginId($form_data["email"])
					->setName($form_data["name"])
					->setDepartment($form_data["name"])
					->setAuthority($this->authorityRepository->find(2))
					->setWork($this->workRepository->find(0))
					->setCreator($this->memberRepository->find(1))
				;

				$this->memberRepository->save($Member);

				$shop = new Shop();
				$shop->setName($form_data["name"]);
				$shop->setEmail($form_data["email"]);
				$shop->setPersionInCharge($form_data["person_in_charge"]);
				$shop->setUrl($form_data["url"]);
				$shop->setOpenStatus($form_data["open_status"]);
				$shop->setIndustryType($form_data["industry_type"]);
				$shop->setPostCode($form_data["postal_code"]);
				$shop->setMtbPrefId($form_data["pref"]->getId());
				$shop->setAddress($form_data["addr01"] . $form_data["addr02"]);
				$shop->setTelephone($form_data["phone_number"]);
				$shop->setUrl($form_data["url"]);
				$shop->setQuestion($form_data["question"]);
				$shop->setMemberId($Member->getId());

				$em = $this->getDoctrine()->getManager();
				$em->persist($shop);
				$em->flush($shop);

				return $this->render("Shop/complete.twig", []);

			}
		}




		return [
			"form" => $form->createView()
		];
	}
}