<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StaffMenu
 *
 * @ORM\Table(name="dtb_staff_menu")
 * @ORM\Entity
 */
class StaffMenu extends \Eccube\Entity\AbstractEntity
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
     * @ORM\Column(name="staff_id", type="integer", nullable=false)
     */
    private $staffId;

    /**
     * @var int
     *
     * @ORM\Column(name="product_id", type="integer", nullable=false)
     */
    private $productId;

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
	 * @return int
	 */
	public function getStaffId(): int
	{
		return $this->staffId;
	}

	/**
	 * @param int $staffId
	 */
	public function setStaffId(int $staffId): void
	{
		$this->staffId = $staffId;
	}

	/**
	 * @return int
	 */
	public function getProductId(): int
	{
		return $this->productId;
	}

	/**
	 * @param int $productId
	 */
	public function setProductId(int $productId): void
	{
		$this->productId = $productId;
	}

}
