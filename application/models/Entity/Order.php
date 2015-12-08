<?php

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Entity\User;
use Entity\Ward;
use Jotun\EntityTimestampsTrait;

/**
 * Order
 *
 * @ORM\Table(name="`order`")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Order
{
    use EntityTimestampsTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", nullable=false)
     */
    private $full_name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", nullable=false)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="coupon", type="string", nullable=true)
     */
    private $coupon;

    /**
     * @ORM\ManyToOne(targetEntity="Entity\User")
     * @ORM\JoinColumn(name="reseller_id", referencedColumnName="id")
     */
    private $reseller;

    /**
     * @ORM\ManyToOne(targetEntity="Entity\Ward", inversedBy="orders")
     */
    private $ward;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="decimal", precision=10, scale=3, nullable=false)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=200, nullable=false)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", length=65535, nullable=true)
     */
    private $note;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="ship_fee", type="decimal", nullable=false)
     */
    private $ship_fee;

    /**
     * @var float
     *
     * @ORM\Column(name="sale_off", type="decimal", options={"default"=0})
     */
    private $sale_off = 0;

    /**
     * @ORM\OneToMany(targetEntity="Entity\OrderDetail", mappedBy="order")
     */
    private $details;

    public function __construct()
    {
        $this->details = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set total
     *
     * @param string $total
     * @return Order
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Order
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Order
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Order
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Order
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User|Object $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function getFullName()
    {
        return $this->full_name;
    }

    public function setFullName($fullName)
    {
        $this->full_name = $fullName;

        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return null|User
     */
    public function getReseller()
    {
        return $this->reseller;
    }

    public function setReseller(User $reseller)
    {
        $this->reseller = $reseller;

        return $this;
    }

    public function getCoupon()
    {
        return $this->coupon;
    }

    public function setCoupon($coupon)
    {
        $this->coupon = $coupon;

        return $this;
    }

    /**
     * @return ArrayCollection|OrderDetail[]
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @return \Entity\Ward
     */
    public function getWard()
    {
        return $this->ward;
    }

    public function getWardName()
    {
        if (is_null($this->ward)) {
            return '#';
        }

        return $this->getWard()->getName();
    }

    public function setWard(Ward $ward)
    {
        $this->ward = $ward;

        return $this;
    }

    /**
     * @return \Datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return \Datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @return float
     */
    public function getShipFee()
    {
        return $this->ship_fee;
    }

    public function setShipFee($fee)
    {
        $this->ship_fee = $fee;

        return $this;
    }

    /**
     * @return float
     */
    public function getSaleOff()
    {
        return $this->sale_off;
    }

    public function setSaleOff($saleOff)
    {
        $this->sale_off = $saleOff;

        return $this;
    }

    public function updateTotal()
    {
        $total = 0;

        foreach ($this->getDetails() as $orderDetail) {
            $total += $orderDetail->getPrice() * $orderDetail->getQuantity();
        }

        $total += $this->ship_fee;
        $this->setTotal($total);
        \Doctrine::getEntityManager()->flush($this);

        return $total;
    }

    public function getBeautyId()
    {
        return '#' . str_pad($this->getId(), 5, '0', STR_PAD_LEFT);
    }
}
