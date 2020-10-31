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
     * @ORM\Column(name="staff_id", type="integer", nullable=true)
     */
    private $staffId;

    /**
     * @var int
     *
     * @ORM\Column(name="menu_id", type="integer", nullable=true)
     */
    private $menuId;

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
	public function getStaffId(): ?int
	{
		return $this->staffId;
	}

	/**
	 * @param int $staffId
	 */
	public function setStaffId(?int $staffId): void
	{
		$this->staffId = $staffId;
	}

	/**
	 * @return int
	 */
	public function getMenuId(): ?int
	{
		return $this->menuId;
	}

	/**
	 * @param int $menuId
	 */
	public function setMenuId(?int $menuId): void
	{
		$this->menuId = $menuId;
	}

}
