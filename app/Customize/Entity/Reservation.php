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
     * @ORM\Column(name="starttime", type="integer", nullable=true)
     */
    private $starttime;

    /**
     * @var int
     *
     * @ORM\Column(name="shop_id", type="integer", nullable=true)
     */
    private $shopId;

    /**
     * @var int
     *
     * @ORM\Column(name="menu_id", type="integer", nullable=true)
     */
    private $menuId;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="staff_id", type="integer", nullable=true)
	 */
	private $staffId;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="status", type="integer", nullable=true, options={"comment"="1:予約可 2:予約ずみ 3:キャンセル"})
	 */
	private $status;

	/**
     * @var string|null
     *
     * @ORM\Column(name="memo", type="text", length=65535, nullable=true)
     */
	private $memo;

	/**
     * @var \DateTime|null
     *
     * @ORM\Column(name="canceled_at", type="datetime", nullable=true)
     */
    private $canceledAt;
	
	/**
     * @var string|null
     *
     * @ORM\Column(name="note", type="text", length=65535, nullable=true)
     */
	private $note;
	
	/**
     * @var string|null
     *
     * @ORM\Column(name="memo_admin", type="text", length=65535, nullable=true)
     */
	private $memoAdmin;
	
	/**
     * @var string|null
     *
     * @ORM\Column(name="message_to_shop", type="text", length=65535, nullable=true)
     */
	private $messageToShop;
	
	/**
	 * @var int
	 *
	 * @ORM\Column(name="message_sended_status", type="integer", nullable=true,  options={"comment"="1:未通知 2:通知済み 3:通知失敗"})
	 */
	private $messageSendedStatus;

	/**
     * @var \DateTime|null
     *
     * @ORM\Column(name="message_sended_at", type="datetime", nullable=true)
     */
	private $messageSendedAt;
	
	/**
	 * @var int
	 *
	 * @ORM\Column(name="customer_id", type="integer", nullable=true)
	 */
	private $customerId;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="point", type="integer", nullable=true)
	 */
	private $point;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="point_sum_before_reservation", type="integer", nullable=true)
	 */
	private $pointSumBeforeReservation;

	/**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
	private $createdAt;

	/**
	 * @var \Customize\Entity\Staff
	 *
	 * @ORM\ManyToOne(targetEntity="Customize\Entity\Staff")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="staff_id", referencedColumnName="id")
	 * })
	 */
	private $staff;

	/**
	 * @var \Customize\Entity\Menu
	 *
	 * @ORM\ManyToOne(targetEntity="Customize\Entity\Menu")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="menu_id", referencedColumnName="id")
	 * })
	 */
	private $menu;

	/**
	 * @var \Eccube\Entity\Customer
	 *
	 * @ORM\ManyToOne(targetEntity="\Eccube\Entity\Customer")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
	 * })
	 */
	private $customer;

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
	public function getStarttime(): ?int
	{
		return $this->starttime;
	}

	/**
	 * @param int $starttime
	 * @return self
	 */
	public function setStarttime(?int $starttime): self
	{
		$this->starttime = $starttime;
		return $this;
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
	 * @return self
	 */
	public function setShopId(?int $shopId): self
	{
		$this->shopId = $shopId;
		return $this;
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
	 * @return self
	 */
	public function setMenuId(?int $menuId): self
	{
		$this->menuId = $menuId;
		return $this;
	}

	/**
	 * Get menu.
	 *
	 * @return \Customize\Entity\Menu|null
	 */
	public function getMenu()
	{
		return $this->menu;
	}

	/**
	 * Set menu.
	 *
	 * @param \Customize\Entity\Menu|null $menu
	 *
	 * @return Reservation
	 */
	public function setMenu(\Customize\Entity\Menu $menu = null)
	{
		$this->menu = $menu;

		return $this;
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
	 * @return self
	 */
	public function setStaffId(?int $staffId): self
	{
		$this->staffId = $staffId;
		return $this;
	}

	/**
	 * Get staff.
	 *
	 * @return \Customize\Entity\Staff|null
	 */
	public function getStaff()
	{
		return $this->staff;
	}

	/**
	 * Set staff.
	 *
	 * @param \Customize\Entity\Staff|null $staff
	 *
	 * @return Reservation
	 */
	public function setStaff(\Customize\Entity\Staff $staff = null)
	{
		$this->staff = $staff;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getStatus(): ?int
	{
		return $this->status;
	}

	/**
	 * @param int $status
	 * @return self
	 */
	public function setStatus(?int $status): self
	{
		$this->status = $status;
		return $this;
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
	public function getCanceledAt(): ?\DateTime
	{
		return $this->canceledAt;
	}

	/**
	 * @param \DateTime|null $canceledAt
	 */
	public function setCanceledAt(?\DateTime $canceledAt): void
	{
		$this->canceledAt = $canceledAt;
	}

	/**
	 * @return null|string
	 */
	public function getNote(): ?string
	{
		return $this->note;
	}

	/**
	 * @param null|string $note
	 */
	public function setNote(?string $note): void
	{
		$this->note = $note;
	}
	
	/**
	 * @return null|string
	 */
	public function getMemoAdmin(): ?string
	{
		return $this->memoAdmin;
	}

	/**
	 * @param null|string $memoAdmin
	 */
	public function setMemoAdmin(?string $memoAdmin): void
	{
		$this->memoAdmin = $memoAdmin;
	}
	
	/**
	 * @return null|string
	 */
	public function getMessageToShop(): ?string
	{
		return $this->messageToShop;
	}

	/**
	 * @param null|string $messageToShop
	 */
	public function setMessageToShop(?string $messageToShop): void
	{
		$this->messageToShop = $messageToShop;
	}
	
	/**
	 * @return int
	 */
	public function getMessageSendedStatus(): ?int
	{
		return $this->messageSendedStatus;
	}

	/**
	 * @param int $messageSendedStatus
	 */
	public function setMessageSendedStatus(?int $messageSendedStatus): void
	{
		$this->messageSendedStatus = $messageSendedStatus;
	}
	
	/**
	 * @return \DateTime|null
	 */
	public function getMessageSendedAt(): ?\DateTime
	{
		return $this->messageSendedAt;
	}

	/**
	 * @param \DateTime|null $messageSendedAt
	 */
	public function setMessageSendedAt(?\DateTime $messageSendedAt): void
	{
		$this->messageSendedAt = $messageSendedAt;
	}

	/**
	 * @return int
	 */
	public function getCustomerId(): ?int
	{
		return $this->customerId;
	}

	/**
	 * @param int $customerId
	 */
	public function setCustomerId(?int $customerId): void
	{
		$this->customerId = $customerId;
	}

	/**
	 * Get customer.
	 *
	 * @return \Eccube\Entity\Customer|null
	 */
	public function getCustomer()
	{
		return $this->customer;
	}

	/**
	 * Set customer.
	 *
	 * @param \Eccube\Entity\Customer|null $customer
	 *
	 * @return Reservation
	 */
	public function setCustomer(\Eccube\Entity\Customer $customer = null)
	{
		$this->customer = $customer;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getPoint(): ?int
	{
		return $this->point;
	}

	/**
	 * @param int $point
	 */
	public function setPoint(?int $point): void
	{
		$this->point = $point;
	}

	/**
	 * @return int
	 */
	public function getPointSumBeforeReservation(): ?int
	{
		return $this->pointSumBeforeReservation;
	}

	/**
	 * @param int $pointSumBeforeReservation
	 */
	public function setPointSumBeforeReservation(?int $pointSumBeforeReservation): void
	{
		$this->pointSumBeforeReservation = $pointSumBeforeReservation;
	}

	/**
	 * @return \DateTime|null
	 */
	public function getCreatedAt(): ?\DateTime
	{
		return $this->createdAt;
	}

	/**
	 * @param \DateTime|null $createdAt
	 */
	public function setCreatedAt(?\DateTime $createdAt): void
	{
		$this->createdAt = $createdAt;
	}
}
