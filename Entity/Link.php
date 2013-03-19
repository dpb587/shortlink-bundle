<?php

namespace DPB\Bundle\ShortlinkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="shortlink_link")
 */
class Link
{
    /**
     * @ORM\Id
     * @ORM\Column(name="code", type="string", length=32)
     */
    protected $code;

    public function setCode($code)
    {
        return $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    /**
     * @ORM\Column(name="url", type="string", length=1024)
     */
    protected $url;

    public function setUrl($url)
    {
        return $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @ORM\Column(name="stat_created_at", type="datetime")
     */
    protected $statCreatedAt;

    public function setStatCreatedAt(\DateTime $statCreatedAt)
    {
        return $this->statCreatedAt = $statCreatedAt;
    }

    public function getStatCreatedAt()
    {
        return $this->statCreatedAt;
    }

    /**
     * @ORM\Column(name="stat_created_by", type="string", length=128)
     */
    protected $statCreatedBy;

    public function setStatCreatedBy($statCreatedBy)
    {
        return $this->statCreatedBy = $statCreatedBy;
    }

    public function getStatCreatedBy()
    {
        return $this->statCreatedBy;
    }

    /**
     * @ORM\Column(name="stat_deleted_at", type="datetime", nullable=true)
     */
    protected $statDeletedAt;

    public function setStatDeletedAt(\DateTime $statDeletedAt)
    {
        return $this->statDeletedAt = $statDeletedAt;
    }

    public function getStatDeletedAt()
    {
        return $this->statDeletedAt;
    }

    /**
     * @ORM\Column(name="stat_deleted_by", type="string", length=128, nullable=true)
     */
    protected $statDeletedBy;

    public function setStatDeletedBy($statDeletedBy)
    {
        return $this->statDeletedBy = $statDeletedBy;
    }

    public function getStatDeletedBy()
    {
        return $this->statDeletedBy;
    }
}
