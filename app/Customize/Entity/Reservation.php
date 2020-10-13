<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="dtb_reservation")
 * @ORM\Entity
 */
class Reservation extends \Eccube\Entity\AbstractEntity
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
     * @ORM\Column(name="order_id", type="integer", nullable=false)
     */
    private $orderId;

    /**
     * @var int
     *
     * @ORM\Column(name="starttime", type="integer", nullable=false)
     */
    private $starttime;

    /**
     * @var int
     *
     * @ORM\Column(name="shop_id", type="integer", nullable=false)
     */
    private $shopId;

    /**
     * @var int
     *
     * @ORM\Column(name="menu_id", type="integer", nullable=false)
     */
    private $menuId;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="staff_id", type="integer", nullable=false)
	 */
	private $staffId;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="status", type="integer", nullable=false, options={"comment"="1:予約可 2:予約ずみ 3:キャンセル"})
	 */
	private $status;

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return self
	 */
	public function setId(int $id): self
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getOrderId(): int
	{
		return $this->orderId;
	}

	/**
	 * @param int $orderId
	 * @return self
	 */
	public function setOrderId(int $orderId): self
	{
		$this->orderId = $orderId;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getStarttime(): int
	{
		return $this->starttime;
	}

	/**
	 * @param int $starttime
	 * @return self
	 */
	public function setStarttime(int $starttime): self
	{
		$this->starttime = $starttime;
		return $this;
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
	 * @return self
	 */
	public function setShopId(int $shopId): self
	{
		$this->shopId = $shopId;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getMenuId(): int
	{
		return $this->menuId;
	}

	/**
	 * @param int $menuId
	 * @return self
	 */
	public function setMenuId(int $menuId): self
	{
		$this->menuId = $menuId;
		return $this;
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
	 * @return self
	 */
	public function setStaffId(int $staffId): self
	{
		$this->staffId = $staffId;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getStatus(): int
	{
		return $this->status;
	}

	/**
	 * @param int $status
	 * @return self
	 */
	public function setStatus(int $status): self
	{
		$this->status = $status;
		return $this;
	}

}
