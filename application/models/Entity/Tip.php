<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tip
 *
 * @ORM\Table(name="tip")
 * @ORM\Entity
 */
class Tip
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
     * @ORM\Column(name="name", type="string", length=200, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="thumb", type="text", length=65535, nullable=false)
     */
    private $thumb;

    /**
     * @var string
     *
     * @ORM\Column(name="review", type="text", length=65535, nullable=false)
     */
    private $review;

    /**
     * @var string
     *
     * @ORM\Column(name="detail", type="text", length=65535, nullable=false)
     */
    private $detail;



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
     * Set name
     *
     * @param string $name
     * @return Tip
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set thumb
     *
     * @param string $thumb
     * @return Tip
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;

        return $this;
    }

    /**
     * Get thumb
     *
     * @return string 
     */
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * Set review
     *
     * @param string $review
     * @return Tip
     */
    public function setReview($review)
    {
        $this->review = $review;

        return $this;
    }

    /**
     * Get review
     *
     * @return string 
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * Set detail
     *
     * @param string $detail
     * @return Tip
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get detail
     *
     * @return string 
     */
    public function getDetail()
    {
        return $this->detail;
    }
}
