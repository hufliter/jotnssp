<?php namespace Jotun;
trait EntityTimestampsTrait
{
    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updated_at;

    /** @ORM\PrePersist */
    public function doStuffOnPrePersist()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    /** @ORM\PreUpdate */
    public function doStuffOnPreUpdate()
    {
        $this->updated_at = new \DateTime();
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
}