<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="dtb_menu")
 * @ORM\Entity
 */
class Menu extends \Eccube\Entity\AbstractEntity
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
     * @var int
     *
     * @ORM\Column(name="title", type="text", length=65535, nullable=true)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="introduction", type="text", length=65535, nullable=true)
     */
    private $introduction;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="text", length=65535, nullable=true)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="category_id", type="integer", nullable=true)
     */
    private $categoryId;

    /**
     * @var int
     *
     * @ORM\Column(name="hotpepper_menu_id", type="text", length=65535, nullable=true)
     */
    private $hotpepperMenuId;

    /**
     * @var int
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
	 * @var \Customize\Entity\Shop
	 *
	 * @ORM\ManyToOne(targetEntity="Customize\Entity\Shop")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="shop_id", referencedColumnName="id")
	 * })
	 */
	private $shop;

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
	public function getShopId(): ?int
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
	 * Get shop.
	 *
	 * @return \Customize\Entity\Shop|null
	 */
	public function getShop()
	{
		return $this->shop;
	}

	/**
	 * Set shop.
	 *
	 * @param \Customize\Entity\Shop|null $shop
	 *
	 * @return Menu
	 */
	public function setShop(\Customize\Entity\Shop $shop = null)
	{
		$this->shop = $shop;

		return $this;
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
	 * @return int
	 */
	public function getCategoryId(): ?int
	{
		return $this->categoryId;
	}

	/**
	 * @param int $categoryId
	 */
	public function setCategoryId(?int $categoryId): void
	{
		$this->categoryId = $categoryId;
	}
    
    /**
	 * @return null|string
	 */
	public function getHotpepperMenuId(): ?string
	{
		return $this->hotpepperMenuId;
	}

	/**
	 * @param null|string $hotpepperMenuId
	 */
	public function setHotpepperMenuId(?string $hotpepperMenuId): void
	{
		$this->hotpepperMenuId = $hotpepperMenuId;
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
