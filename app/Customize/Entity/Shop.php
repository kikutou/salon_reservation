<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Entity\Master\Pref;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Shop
 *
 * @ORM\Table(name="dtb_shop")
 * @ORM\Entity
 */
class Shop extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true,"comment"="ID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="member_id", type="integer", nullable=false, options={"comment"="メンバーID"})
     */
    private $memberId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="open_status", type="integer", nullable=true, options={"default"="1","comment"="開業状況
1: 開業済み 2: 開業予定
"})
     */
    private $openStatus = '1';

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="text", length=65535, nullable=true, options={"comment"="店舗名"})
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="person_in_charge", type="text", length=65535, nullable=true, options={"comment"="担当者名"})
     */
    private $personInCharge;

    /**
     * @var int|null
     *
     * @ORM\Column(name="industry_type", type="integer", nullable=true, options={"comment"="業種 1:ヘアサロン 2:ネイル・まつげサロン 3:リラクサロン 4.エステサロン 5. その他"})
     */
    private $industryType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="post_code", type="string", length=7, nullable=true)
     */
    private $postCode;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(name="token", type="string", length=16, nullable=true)
	 */
	private $token;

	/**
	 * @return null|string
	 */
	public function getToken(): ?string
	{
		return $this->token;
	}

	/**
	 * @param null|string $token
	 */
	public function setToken(?string $token): void
	{
		$this->token = $token;
	}

    /**
     * @var int|null
     *
     * @ORM\Column(name="mtb_pref_id", type="integer", nullable=true)
     */
    private $mtbPrefId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="text", length=65535, nullable=true)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telephone", type="text", length=65535, nullable=true)
     */
    private $telephone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="text", length=65535, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="url", type="text", length=65535, nullable=true)
     */
    private $url;

    /**
     * @var string|null
     *
     * @ORM\Column(name="question", type="text", length=65535, nullable=true)
     */
    private $question;

    /**
     * @var int|null
     *
     * @ORM\Column(name="authenticated_by_admin", type="integer", nullable=true, options={"comment"="1: 審査中 2:審査済み 3：却下　※却下は直接削除になるため、該当ステータスは基本的に使わない。"})
     */
    private $authenticatedByAdmin;

    /**
     * @var int|null
     *
     * @ORM\Column(name="public_status", type="integer", nullable=true, options={"comment"="1: 非公開 2:公開"})
     */
    private $publicStatus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="logo", type="text", length=65535, nullable=true)
     */
    private $logo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="top_images", type="text", length=65535, nullable=true)
     */
    private $topImages;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tags", type="text", length=65535, nullable=true)
     */
    private $tags;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sub_name", type="text", length=65535, nullable=true)
     */
    private $subName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="access", type="text", length=65535, nullable=true)
     */
    private $access;

    /**
     * @var string|null
     *
     * @ORM\Column(name="business_hours", type="text", length=65535, nullable=true)
     */
    private $businessHours;

    /**
     * @var string|null
     *
     * @ORM\Column(name="credit_cards_info", type="text", length=65535, nullable=true)
     */
    private $creditCardsInfo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="price", type="text", length=65535, nullable=true)
     */
    private $price;

    /**
     * @var string|null
     *
     * @ORM\Column(name="seats", type="text", length=65535, nullable=true)
     */
    private $seats;

    /**
     * @var string|null
     *
     * @ORM\Column(name="staff_number", type="text", length=65535, nullable=true)
     */
    private $staffNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="parking_area", type="text", length=65535, nullable=true)
     */
    private $parkingArea;

    /**
     * @var string|null
     *
     * @ORM\Column(name="conditions", type="text", length=65535, nullable=true)
     */
    private $conditions;

    /**
     * @var string|null
     *
     * @ORM\Column(name="introduction_title", type="text", length=65535, nullable=true)
     */
    private $introductionTitle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="introduction", type="text", length=65535, nullable=true)
     */
    private $introduction;

    /**
     * @var string|null
     *
     * @ORM\Column(name="introduction_images", type="text", length=65535, nullable=true)
     */
    private $introductionImages;

    /**
     * @var string|null
     *
     * @ORM\Column(name="commitment_title_1", type="text", length=65535, nullable=true)
     */
    private $commitmentTitle1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="commitment_image_1", type="text", length=65535, nullable=true)
     */
    private $commitmentImage1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="commitment_introduction_1", type="text", length=65535, nullable=true)
     */
    private $commitmentIntroduction1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="commitment_title_2", type="text", length=65535, nullable=true)
     */
    private $commitmentTitle2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="commitment_image_2", type="text", length=65535, nullable=true)
     */
    private $commitmentImage2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="commitment_introduction_2", type="text", length=65535, nullable=true)
     */
    private $commitmentIntroduction2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="environment_title_1", type="text", length=65535, nullable=true)
     */
    private $environmentTitle1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="environment_image_1", type="text", length=65535, nullable=true)
     */
    private $environmentImage1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="environment_introduction_1", type="text", length=65535, nullable=true)
     */
    private $environmentIntroduction1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="environment_title_2", type="text", length=65535, nullable=true)
     */
    private $environmentTitle2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="environment_image_2", type="text", length=65535, nullable=true)
     */
    private $environmentImage2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="environment_introduction_2", type="text", length=65535, nullable=true)
     */
    private $environmentIntroduction2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="environment_title_3", type="text", length=65535, nullable=true)
     */
    private $environmentTitle3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="environment_image_3", type="text", length=65535, nullable=true)
     */
    private $environmentImage3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="environment_introduction_3", type="text", length=65535, nullable=true)
     */
    private $environmentIntroduction3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="message", type="text", length=65535, nullable=true)
     */
    private $message;

    /**
     * @var string|null
     *
     * @ORM\Column(name="message_staff_position", type="text", length=65535, nullable=true)
     */
    private $messageStaffPosition;

    /**
     * @var string|null
     *
     * @ORM\Column(name="message_staff", type="text", length=65535, nullable=true)
     */
    private $messageStaff;

    /**
     * @var string|null
     *
     * @ORM\Column(name="message_image", type="text", length=65535, nullable=true)
     */
    private $messageImage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="memo", type="text", length=65535, nullable=true)
     */
    private $memo;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="create_date", type="datetime", nullable=true)
     */
    private $createDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="update_date", type="datetime", nullable=true)
     */
    private $updateDate;


    private $pref;

	/**
	 * @return Pref
	 */
	public function getPref(): Pref
	{
		return $this->pref;
	}

	/**
	 * @param Pref $pref
	 */
	public function setPref(Pref $pref): void
	{
		$this->pref = $pref;
	}

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId(int $id): void
	{
		$this->id = $id;
	}

	/**
	 * @return int
	 */
	public function getMemberId(): int
	{
		return $this->memberId;
	}

	/**
	 * @param int $memberId
	 */
	public function setMemberId(int $memberId): void
	{
		$this->memberId = $memberId;
	}

	/**
	 * @return int|null
	 */
	public function getOpenStatus(): ?int
	{
		return $this->openStatus;
	}

	/**
	 * @param int|null $openStatus
	 */
	public function setOpenStatus(?int $openStatus): void
	{
		$this->openStatus = $openStatus;
	}

	/**
	 * @return null|string
	 */
	public function getName(): ?string
	{
		return $this->name;
	}

	/**
	 * @param null|string $name
	 */
	public function setName(?string $name): void
	{
		$this->name = $name;
	}

	/**
	 * @return null|string
	 */
	public function getPersonInCharge(): ?string
	{
		return $this->personInCharge;
	}

	/**
	 * @param null|string $personInCharge
	 */
	public function setPersonInCharge(?string $personInCharge): void
	{
		$this->personInCharge = $personInCharge;
	}

	/**
	 * @return int|null
	 */
	public function getIndustryType(): ?int
	{
		return $this->industryType;
	}

	/**
	 * @param int|null $industryType
	 */
	public function setIndustryType(?int $industryType): void
	{
		$this->industryType = $industryType;
	}

	/**
	 * @return null|string
	 */
	public function getPostCode(): ?string
	{
		return $this->postCode;
	}

	/**
	 * @param null|string $postCode
	 */
	public function setPostCode(?string $postCode): void
	{
		$this->postCode = $postCode;
	}

	/**
	 * @return int|null
	 */
	public function getMtbPrefId(): ?int
	{
		return $this->mtbPrefId;
	}

	/**
	 * @param int|null $mtbPrefId
	 */
	public function setMtbPrefId(?int $mtbPrefId): void
	{
		$this->mtbPrefId = $mtbPrefId;
	}

	/**
	 * @return null|string
	 */
	public function getAddress(): ?string
	{
		return $this->address;
	}

	/**
	 * @param null|string $address
	 */
	public function setAddress(?string $address): void
	{
		$this->address = $address;
	}

	/**
	 * @return null|string
	 */
	public function getTelephone(): ?string
	{
		return $this->telephone;
	}

	/**
	 * @param null|string $telephone
	 */
	public function setTelephone(?string $telephone): void
	{
		$this->telephone = $telephone;
	}

	/**
	 * @return null|string
	 */
	public function getEmail(): ?string
	{
		return $this->email;
	}

	/**
	 * @param null|string $email
	 */
	public function setEmail(?string $email): void
	{
		$this->email = $email;
	}

	/**
	 * @return null|string
	 */
	public function getUrl(): ?string
	{
		return $this->url;
	}

	/**
	 * @param null|string $url
	 */
	public function setUrl(?string $url): void
	{
		$this->url = $url;
	}

	/**
	 * @return null|string
	 */
	public function getQuestion(): ?string
	{
		return $this->question;
	}

	/**
	 * @param null|string $question
	 */
	public function setQuestion(?string $question): void
	{
		$this->question = $question;
	}

	/**
	 * @return int|null
	 */
	public function getAuthenticatedByAdmin(): ?int
	{
		return $this->authenticatedByAdmin;
	}

	/**
	 * @param int|null $authenticatedByAdmin
	 */
	public function setAuthenticatedByAdmin(?int $authenticatedByAdmin): void
	{
		$this->authenticatedByAdmin = $authenticatedByAdmin;
	}

	/**
	 * @return int|null
	 */
	public function getPublicStatus(): ?int
	{
		return $this->publicStatus;
	}

	/**
	 * @param int|null $publicStatus
	 */
	public function setPublicStatus(?int $publicStatus): void
	{
		$this->publicStatus = $publicStatus;
	}

	/**
	 * @return null|string
	 */
	public function getLogo(): ?string
	{
		return $this->logo;
	}


	/**
	 * @return null|string
	 */
	public function getLogoImage(): ?string
	{
		return $this->logo;
	}

	public function setLogoImage(?string $logo): void
	{
		$this->logo = $logo;
	}

	/**
	 * @param null|string $logo
	 */
	public function setLogo(?string $logo): void
	{
		$this->logo = $logo;
	}

	/**
	 * @return null|string
	 */
	public function getTopImages(): ?string
	{
		return $this->topImages;
	}

	/**
	 * @param null|string $topImages
	 */
	public function setTopImages(?string $topImages): void
	{
		$this->topImages = $topImages;
	}

	/**
	 * @return null|string
	 */
	public function getTags(): ?string
	{
		return $this->tags;
	}

	/**
	 * @param null|string $tags
	 */
	public function setTags(?string $tags): void
	{
		$this->tags = $tags;
	}

	/**
	 * @return null|string
	 */
	public function getSubName(): ?string
	{
		return $this->subName;
	}

	/**
	 * @param null|string $subName
	 */
	public function setSubName(?string $subName): void
	{
		$this->subName = $subName;
	}

	/**
	 * @return null|string
	 */
	public function getAccess(): ?string
	{
		return $this->access;
	}

	/**
	 * @param null|string $access
	 */
	public function setAccess(?string $access): void
	{
		$this->access = $access;
	}

	/**
	 * @return null|string
	 */
	public function getBusinessHours(): ?string
	{
		return $this->businessHours;
	}

	/**
	 * @param null|string $businessHours
	 */
	public function setBusinessHours(?string $businessHours): void
	{
		$this->businessHours = $businessHours;
	}

	/**
	 * @return null|string
	 */
	public function getCreditCardsInfo(): ?string
	{
		return $this->creditCardsInfo;
	}

	/**
	 * @param null|string $creditCardsInfo
	 */
	public function setCreditCardsInfo(?string $creditCardsInfo): void
	{
		$this->creditCardsInfo = $creditCardsInfo;
	}

	/**
	 * @return null|string
	 */
	public function getPrice(): ?string
	{
		return $this->price;
	}

	/**
	 * @param null|string $price
	 */
	public function setPrice(?string $price): void
	{
		$this->price = $price;
	}

	/**
	 * @return null|string
	 */
	public function getSeats(): ?string
	{
		return $this->seats;
	}

	/**
	 * @param null|string $seats
	 */
	public function setSeats(?string $seats): void
	{
		$this->seats = $seats;
	}

	/**
	 * @return null|string
	 */
	public function getStaffNumber(): ?string
	{
		return $this->staffNumber;
	}

	/**
	 * @param null|string $staffNumber
	 */
	public function setStaffNumber(?string $staffNumber): void
	{
		$this->staffNumber = $staffNumber;
	}

	/**
	 * @return null|string
	 */
	public function getParkingArea(): ?string
	{
		return $this->parkingArea;
	}

	/**
	 * @param null|string $parkingArea
	 */
	public function setParkingArea(?string $parkingArea): void
	{
		$this->parkingArea = $parkingArea;
	}

	/**
	 * @return null|string
	 */
	public function getConditions(): ?string
	{
		return $this->conditions;
	}

	/**
	 * @param null|string $conditions
	 */
	public function setConditions(?string $conditions): void
	{
		$this->conditions = $conditions;
	}

	/**
	 * @return null|string
	 */
	public function getIntroductionTitle(): ?string
	{
		return $this->introductionTitle;
	}

	/**
	 * @param null|string $introductionTitle
	 */
	public function setIntroductionTitle(?string $introductionTitle): void
	{
		$this->introductionTitle = $introductionTitle;
	}

	/**
	 * @return null|string
	 */
	public function getIntroduction(): ?string
	{
		return $this->introduction;
	}

	/**
	 * @param null|string $introduction
	 */
	public function setIntroduction(?string $introduction): void
	{
		$this->introduction = $introduction;
	}

	/**
	 * @return null|string
	 */
	public function getIntroductionImages(): ?string
	{
		return $this->introductionImages;
	}

	/**
	 * @param null|string $introductionImages
	 */
	public function setIntroductionImages(?string $introductionImages): void
	{
		$this->introductionImages = $introductionImages;
	}

	/**
	 * @return null|string
	 */
	public function getCommitmentTitle1(): ?string
	{
		return $this->commitmentTitle1;
	}

	/**
	 * @param null|string $commitmentTitle1
	 */
	public function setCommitmentTitle1(?string $commitmentTitle1): void
	{
		$this->commitmentTitle1 = $commitmentTitle1;
	}

	/**
	 * @return null|string
	 */
	public function getCommitmentImage1(): ?string
	{
		return $this->commitmentImage1;
	}

	/**
	 * @param null|string $commitmentImage1
	 */
	public function setCommitmentImage1(?string $commitmentImage1): void
	{
		$this->commitmentImage1 = $commitmentImage1;
	}

	/**
	 * @return null|string
	 */
	public function getCommitmentIntroduction1(): ?string
	{
		return $this->commitmentIntroduction1;
	}

	/**
	 * @param null|string $commitmentIntroduction1
	 */
	public function setCommitmentIntroduction1(?string $commitmentIntroduction1): void
	{
		$this->commitmentIntroduction1 = $commitmentIntroduction1;
	}

	/**
	 * @return null|string
	 */
	public function getCommitmentTitle2(): ?string
	{
		return $this->commitmentTitle2;
	}

	/**
	 * @param null|string $commitmentTitle2
	 */
	public function setCommitmentTitle2(?string $commitmentTitle2): void
	{
		$this->commitmentTitle2 = $commitmentTitle2;
	}

	/**
	 * @return null|string
	 */
	public function getCommitmentImage2(): ?string
	{
		return $this->commitmentImage2;
	}

	/**
	 * @param null|string $commitmentImage2
	 */
	public function setCommitmentImage2(?string $commitmentImage2): void
	{
		$this->commitmentImage2 = $commitmentImage2;
	}

	/**
	 * @return null|string
	 */
	public function getCommitmentIntroduction2(): ?string
	{
		return $this->commitmentIntroduction2;
	}

	/**
	 * @param null|string $commitmentIntroduction2
	 */
	public function setCommitmentIntroduction2(?string $commitmentIntroduction2): void
	{
		$this->commitmentIntroduction2 = $commitmentIntroduction2;
	}

	/**
	 * @return null|string
	 */
	public function getEnvironmentTitle1(): ?string
	{
		return $this->environmentTitle1;
	}

	/**
	 * @param null|string $environmentTitle1
	 */
	public function setEnvironmentTitle1(?string $environmentTitle1): void
	{
		$this->environmentTitle1 = $environmentTitle1;
	}

	/**
	 * @return null|string
	 */
	public function getEnvironmentImage1(): ?string
	{
		return $this->environmentImage1;
	}

	/**
	 * @param null|string $environmentImage1
	 */
	public function setEnvironmentImage1(?string $environmentImage1): void
	{
		$this->environmentImage1 = $environmentImage1;
	}

	/**
	 * @return null|string
	 */
	public function getEnvironmentIntroduction1(): ?string
	{
		return $this->environmentIntroduction1;
	}

	/**
	 * @param null|string $environmentIntroduction1
	 */
	public function setEnvironmentIntroduction1(?string $environmentIntroduction1): void
	{
		$this->environmentIntroduction1 = $environmentIntroduction1;
	}

	/**
	 * @return null|string
	 */
	public function getEnvironmentTitle2(): ?string
	{
		return $this->environmentTitle2;
	}

	/**
	 * @param null|string $environmentTitle2
	 */
	public function setEnvironmentTitle2(?string $environmentTitle2): void
	{
		$this->environmentTitle2 = $environmentTitle2;
	}

	/**
	 * @return null|string
	 */
	public function getEnvironmentImage2(): ?string
	{
		return $this->environmentImage2;
	}

	/**
	 * @param null|string $environmentImage2
	 */
	public function setEnvironmentImage2(?string $environmentImage2): void
	{
		$this->environmentImage2 = $environmentImage2;
	}

	/**
	 * @return null|string
	 */
	public function getEnvironmentIntroduction2(): ?string
	{
		return $this->environmentIntroduction2;
	}

	/**
	 * @param null|string $environmentIntroduction2
	 */
	public function setEnvironmentIntroduction2(?string $environmentIntroduction2): void
	{
		$this->environmentIntroduction2 = $environmentIntroduction2;
	}

	/**
	 * @return null|string
	 */
	public function getEnvironmentTitle3(): ?string
	{
		return $this->environmentTitle3;
	}

	/**
	 * @param null|string $environmentTitle3
	 */
	public function setEnvironmentTitle3(?string $environmentTitle3): void
	{
		$this->environmentTitle3 = $environmentTitle3;
	}

	/**
	 * @return null|string
	 */
	public function getEnvironmentImage3(): ?string
	{
		return $this->environmentImage3;
	}

	/**
	 * @param null|string $environmentImage3
	 */
	public function setEnvironmentImage3(?string $environmentImage3): void
	{
		$this->environmentImage3 = $environmentImage3;
	}

	/**
	 * @return null|string
	 */
	public function getEnvironmentIntroduction3(): ?string
	{
		return $this->environmentIntroduction3;
	}

	/**
	 * @param null|string $environmentIntroduction3
	 */
	public function setEnvironmentIntroduction3(?string $environmentIntroduction3): void
	{
		$this->environmentIntroduction3 = $environmentIntroduction3;
	}

	/**
	 * @return null|string
	 */
	public function getMessage(): ?string
	{
		return $this->message;
	}

	/**
	 * @param null|string $message
	 */
	public function setMessage(?string $message): void
	{
		$this->message = $message;
	}

	/**
	 * @return null|string
	 */
	public function getMessageStaffPosition(): ?string
	{
		return $this->messageStaffPosition;
	}

	/**
	 * @param null|string $messageStaffPosition
	 */
	public function setMessageStaffPosition(?string $messageStaffPosition): void
	{
		$this->messageStaffPosition = $messageStaffPosition;
	}

	/**
	 * @return null|string
	 */
	public function getMessageStaff(): ?string
	{
		return $this->messageStaff;
	}

	/**
	 * @param null|string $messageStaff
	 */
	public function setMessageStaff(?string $messageStaff): void
	{
		$this->messageStaff = $messageStaff;
	}

	/**
	 * @return null|string
	 */
	public function getMessageImage(): ?string
	{
		return $this->messageImage;
	}

	/**
	 * @param null|string $messageImage
	 */
	public function setMessageImage(?string $messageImage): void
	{
		$this->messageImage = $messageImage;
	}

	/**
	 * @return null|string
	 */
	public function getMemo(): ?string
	{
		return $this->memo;
	}

	/**
	 * @param null|string $memo
	 */
	public function setMemo(?string $memo): void
	{
		$this->memo = $memo;
	}

	/**
	 * @return \DateTime|null
	 */
	public function getCreateDate(): ?\DateTime
	{
		return $this->createDate;
	}

	/**
	 * @param \DateTime|null $createDate
	 */
	public function setCreateDate(?\DateTime $createDate): void
	{
		$this->createDate = $createDate;
	}

	/**
	 * @return \DateTime|null
	 */
	public function getUpdateDate(): ?\DateTime
	{
		return $this->updateDate;
	}

	/**
	 * @param \DateTime|null $updateDate
	 */
	public function setUpdateDate(?\DateTime $updateDate): void
	{
		$this->updateDate = $updateDate;
	}


	public static function generateRandomString($length = 10) {
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

	public function getIndustryTypeName() {
		$choices = [
			"ヘアサロン" => 1,
			"ネイル・まつげサロン" => 2,
			"リラクスサロン" => 3,
			"エステサロン" => 4,
			"その他" => 5,
		];

		foreach ($choices as $key=>$value) {
			if($value == $this->getIndustryType()) {
				return $key;
			}
		}

		return null;
	}


	public function getAuthenticatedByAdminStatus() {
		if($this->getAuthenticatedByAdmin() == 1) {
			return "審査中";
		}

		if($this->getAuthenticatedByAdmin() == 2) {
			return "審査済み";
		}

		if($this->getAuthenticatedByAdmin() == 1) {
			return "却下";
		}

		return "状況不明";
	}


	public function getPublicStatusString() {
		if($this->getPublicStatus() == 1) {
			return "非公開";
		}

		if($this->getPublicStatus() == 2) {
			return "公開";
		}

		return "状況不明";
	}






}
