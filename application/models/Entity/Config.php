<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Config
 *
 * @ORM\Table(name="config")
 * @ORM\Entity
 */
class Config
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
     * @var boolean
     *
     * @ORM\Column(name="advertise", type="boolean", nullable=false)
     */
    private $advertise;

    /**
     * @var string
     *
     * @ORM\Column(name="cks", type="text", length=65535, nullable=false)
     */
    private $cks;

    /**
     * @var string
     *
     * @ORM\Column(name="gnh", type="text", length=65535, nullable=false)
     */
    private $gnh;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="reason", type="text", length=65535, nullable=false)
     */
    private $reason;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", length=50, nullable=true)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=100, nullable=false)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="ck", type="text", length=65535, nullable=false)
     */
    private $ck;

    /**
     * @var string
     *
     * @ORM\Column(name="ckt", type="text", length=65535, nullable=false)
     */
    private $ckt;

    /**
     * @var string
     *
     * @ORM\Column(name="tax_code", type="string", length=255, nullable=false)
     */
    private $tax_code;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;



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
     * Set advertise
     *
     * @param boolean $advertise
     * @return Config
     */
    public function setAdvertise($advertise)
    {
        $this->advertise = $advertise;

        return $this;
    }

    /**
     * Get advertise
     *
     * @return boolean 
     */
    public function getAdvertise()
    {
        return $this->advertise;
    }

    /**
     * Set cks
     *
     * @param string $cks
     * @return Config
     */
    public function setCks($cks)
    {
        $this->cks = $cks;

        return $this;
    }

    /**
     * Get cks
     *
     * @return string 
     */
    public function getCks()
    {
        return $this->cks;
    }

    /**
     * Set gnh
     *
     * @param string $gnh
     * @return Config
     */
    public function setGnh($gnh)
    {
        $this->gnh = $gnh;

        return $this;
    }

    /**
     * Get gnh
     *
     * @return string 
     */
    public function getGnh()
    {
        return $this->gnh;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Config
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set reason
     *
     * @param string $reason
     * @return Config
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason
     *
     * @return string 
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set contact
     *
     * @param string $contact
     * @return Config
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Config
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set ck
     *
     * @param string $ck
     * @return Config
     */
    public function setCk($ck)
    {
        $this->ck = $ck;

        return $this;
    }

    /**
     * Get ck
     *
     * @return string 
     */
    public function getCk()
    {
        return $this->ck;
    }

    /**
     * Set ckt
     *
     * @param string $ckt
     * @return Config
     */
    public function setCkt($ckt)
    {
        $this->ckt = $ckt;

        return $this;
    }

    /**
     * Get ckt
     *
     * @return string 
     */
    public function getCkt()
    {
        return $this->ckt;
    }

    /**
     * Set tax_code
     *
     * @param string $tax_code
     * @return Config
     */
    public function setTaxcode($tax_code)
    {
        $this->tax_code = $tax_code;

        return $this;
    }

    /**
     * Get tax_code
     *
     * @return string
     */
    public function getTaxcode()
    {
        return $this->tax_code;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Config
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
