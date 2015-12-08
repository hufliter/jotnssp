<?php namespace Entity;
use Doctrine\ORM\Mapping as ORM;
use Jotun\EntityTimestampsTrait;
use Jotun\EntityAutoIdTrait;
/**
 * @ORM\Entity
 * @ORM\Table(name="reseller_payment_detail")
 * @ORM\HasLifecycleCallbacks
 */
class ResellerPaymentDetail
{
    use EntityTimestampsTrait,
        EntityAutoIdTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Entity\ResellerPayment")
     * @ORM\JoinColumn(name="payment_id", referencedColumnName="id")
     */
    private $reseller_payment;

    /**
     * @ORM\ManyToOne(targetEntity="Entity\Order")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    private $order;

    /**
     * @var float
     * @ORM\Column(name="amount", type="decimal", nullable=false)
     */
    private $amount;

    /**
     * @return ResellerPayment
     */
    public function getResellerPayment()
    {
        return $this->reseller_payment;
    }

    /**
     * @param ResellerPayment $payment
     * @return $this
     */
    public function setResellerPayment($payment)
    {
        $this->reseller_payment = $payment;

        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
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
}