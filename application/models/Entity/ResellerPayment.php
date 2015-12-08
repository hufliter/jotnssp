<?php namespace Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Jotun\EntityTimestampsTrait;
use Jotun\EntityAutoIdTrait;

/**
 * @ORM\Table(name="`reseller_payment`", indexes={@ORM\Index(name="idx_time_code", columns={"time_code", "reseller_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ResellerPayment
{
    use EntityAutoIdTrait,
        EntityTimestampsTrait;
    /**
     * @ORM\ManyToOne(targetEntity="Entity\User")
     * @ORM\JoinColumn(name="reseller_id", referencedColumnName="id")
     */
    private $reseller;

    /**
     * @ORM\Column(name="amount", type="decimal", nullable=false)
     */
    private $amount;

    /**
     * @var string
     * @ORM\Column(name="time_code", type="string", nullable=false)
     */
    private $time_code;

    /**
     * @ORM\OneToMany(targetEntity="Entity\ResellerPaymentDetail", mappedBy="reseller_payment")
     */
    private $details;

    public function __construct()
    {
        $this->details = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|ResellerPaymentDetail
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return \Entity\User
     */
    public function getReseller()
    {
        return $this->reseller;
    }

    /**
     * @param \Entity\User $reseller
     * @return $this
     */
    public function setReseller($reseller)
    {
        $this->reseller = $reseller;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimeCode()
    {
        return $this->time_code;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setTimeCode($code)
    {
        $this->time_code = $code;

        return $this;
    }
}