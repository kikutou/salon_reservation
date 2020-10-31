<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Staff
 *
 * @ORM\Table(name="dtb_staff")
 * @ORM\Entity
 */
class Staff extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="shop_id", type="integer", nullable=false)
     */
	private $shopId;
	
	/**
     * @var string|null
     *
     * @ORM\Column(name="hotpepper_staff_id", type="text", length=65535, nullable=true)
     */
    private $hotpepperStaffId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="text", length=65535, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="text", length=65535, nullable=true)
     */
    private $image;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="text", length=65535, nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="introduction", type="text", length=65535, nullable=true)
     */
    private $introduction;

    /**
     * @var string|null
     *
     * @ORM\Column(name="experience", type="text", length=65535, nullable=true)
     */
    private $experience;

    /**
     * @var string|null
     *
     * @ORM\Column(name="style", type="text", length=65535, nullable=true)
     */
    private $style;

    /**
     * @var string|null
     *
     * @ORM\Column(name="skills", type="text", length=65535, nullable=true)
     */
    private $skills;

    /**
     * @var string|null
     *
     * @ORM\Column(name="hobbies", type="text", length=65535, nullable=true)
     */
    private $hobbies;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image_1", type="text", length=65535, nullable=true)
     */
    private $image1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment_1", type="text", length=65535, nullable=true)
     */
    private $comment1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image_2", type="text", length=65535, nullable=true)
     */
    private $image2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment_2", type="text", length=65535, nullable=true)
     */
    private $comment2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image_3", type="text", length=65535, nullable=true)
     */
    private $image3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment_3", type="text", length=65535, nullable=true)
     */
    private $comment3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image_4", type="text", length=65535, nullable=true)
     */
    private $image4;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment_4", type="text", length=65535, nullable=true)
     */
    private $comment4;

    /**
     * @var string|null
     *
     * @ORM\Column(name="business_hours", type="text", length=65535, nullable=true)
     */
    private $businessHours;

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
	public function getShopId(): int
	{
		return $this->shopId;
	}

	/**
	 * @param int $shopId
	 */
	public function setShopId(int $shopId): void
	{
		$this->shopId = $shopId;
	}

	/**
	 * @return null|string
	 */
	public function getHotpepperStaffId(): ?string
	{
		return $this->hotpepperStaffId;
	}

	/**
	 * @param null|string $hotpepperStaffId
	 */
	public function setHotpepperStaffId(?string $hotpepperStaffId): void
	{
		$this->hotpepperStaffId = $hotpepperStaffId;
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
	public function getImage(): ?string
	{
		return $this->image;
	}

	/**
	 * @param null|string $image
	 */
	public function setImage(?string $image): void
	{
		$this->image = $image;
	}

	/**
	 * @return null|string
	 */
	public function getTitle(): ?string
	{
		return $this->title;
	}

	/**
	 * @param null|string $title
	 */
	public function setTitle(?string $title): void
	{
		$this->title = $title;
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
	public function getExperience(): ?string
	{
		return $this->experience;
	}

	/**
	 * @param null|string $experience
	 */
	public function setExperience(?string $experience): void
	{
		$this->experience = $experience;
	}

	/**
	 * @return null|string
	 */
	public function getStyle(): ?string
	{
		return $this->style;
	}

	/**
	 * @param null|string $style
	 */
	public function setStyle(?string $style): void
	{
		$this->style = $style;
	}

	/**
	 * @return null|string
	 */
	public function getSkills(): ?string
	{
		return $this->skills;
	}

	/**
	 * @param null|string $skills
	 */
	public function setSkills(?string $skills): void
	{
		$this->skills = $skills;
	}

	/**
	 * @return null|string
	 */
	public function getHobbies(): ?string
	{
		return $this->hobbies;
	}

	/**
	 * @param null|string $hobbies
	 */
	public function setHobbies(?string $hobbies): void
	{
		$this->hobbies = $hobbies;
	}

	/**
	 * @return null|string
	 */
	public function getImage1(): ?string
	{
		return $this->image1;
	}

	/**
	 * @param null|string $image1
	 */
	public function setImage1(?string $image1): void
	{
		$this->image1 = $image1;
	}

	/**
	 * @return null|string
	 */
	public function getComment1(): ?string
	{
		return $this->comment1;
	}

	/**
	 * @param null|string $comment1
	 */
	public function setComment1(?string $comment1): void
	{
		$this->comment1 = $comment1;
	}

	/**
	 * @return null|string
	 */
	public function getImage2(): ?string
	{
		return $this->image2;
	}

	/**
	 * @param null|string $image2
	 */
	public function setImage2(?string $image2): void
	{
		$this->image2 = $image2;
	}

	/**
	 * @return null|string
	 */
	public function getComment2(): ?string
	{
		return $this->comment2;
	}

	/**
	 * @param null|string $comment2
	 */
	public function setComment2(?string $comment2): void
	{
		$this->comment2 = $comment2;
	}

	/**
	 * @return null|string
	 */
	public function getImage3(): ?string
	{
		return $this->image3;
	}

	/**
	 * @param null|string $image3
	 */
	public function setImage3(?string $image3): void
	{
		$this->image3 = $image3;
	}

	/**
	 * @return null|string
	 */
	public function getComment3(): ?string
	{
		return $this->comment3;
	}

	/**
	 * @param null|string $comment3
	 */
	public function setComment3(?string $comment3): void
	{
		$this->comment3 = $comment3;
	}

	/**
	 * @return null|string
	 */
	public function getImage4(): ?string
	{
		return $this->image4;
	}

	/**
	 * @param null|string $image4
	 */
	public function setImage4(?string $image4): void
	{
		$this->image4 = $image4;
	}

	/**
	 * @return null|string
	 */
	public function getComment4(): ?string
	{
		return $this->comment4;
	}

	/**
	 * @param null|string $comment4
	 */
	public function setComment4(?string $comment4): void
	{
		$this->comment4 = $comment4;
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




}
