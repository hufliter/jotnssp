<?php namespace Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="`ward`")
 * @ORM\Entity
 */
class Ward
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="`name`", type="string", nullable=false)
     */
    private $name;

    /**
     * @var float
     * @ORM\Column(name="ship_fee", type="decimal", nullable=true)
     */
    private $ship_fee;

    /**
     * @ORM\OneToMany(targetEntity="Entity\Order", mappedBy="ward")
     */
    private $orders;

    /**
     * @var string
     * @ORM\Column(name="message", type="string")
     */
    private $message;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getShipFee()
    {
        return $this->ship_fee;
    }

    public function setShipFee($fee)
    {
        $this->ship_fee = $fee;
        return $this;
    }

    public function getOrders()
    {
        return $this->orders;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }
}