<?php

namespace DPB\Bundle\ShortlinkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="link_click")
 */
class Click
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    public function setId($id)
    {
        return $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\ManyToOne(targetEntity="DPB\Bundle\ShortlinkBundle\Entity\Link")
     * @ORM\JoinColumn(name="link_id", referencedColumnName="code")
     */
    protected $link;

    public function setLink(Link $link)
    {
        return $this->link = $link;
    }

    public function getShortlink()
    {
        return $this->link;
    }

    /**
     * @ORM\Column(name="ip_address", type="string", length=45)
     */
    protected $ipAddress;

    public function setIpAddress($ipAddress)
    {
        return $this->ipAddress = $ipAddress;
    }

    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @ORM\Column(name="user_agent", type="string", length=128, nullable=true)
     */
    protected $userAgent;

    public function setUserAgent($userAgent)
    {
        return $this->userAgent = $userAgent;
    }

    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @ORM\Column(name="referrer", type="string", length=128, nullable=true)
     */
    protected $referrer;

    public function setReferrer($referrer)
    {
        return $this->referrer = $referrer;
    }

    public function getReferrer()
    {
        return $this->referrer;
    }

    /**
     * @ORM\Column(name="stat_clicked_at", type="datetime")
     */
    protected $statClickedAt;

    public function setStatClickedAt(\DateTime $statClickedAt)
    {
        return $this->statClickedAt = $statClickedAt;
    }

    public function getStatClickedAt()
    {
        return $this->statClickedAt;
    }
}
