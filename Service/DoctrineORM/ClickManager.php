<?php

namespace DPB\Bundle\ShortlinkBundle\Service\DoctrineORM;

use DateTime;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use DPB\Bundle\ShortlinkBundle\Entity\Link;
use DPB\Bundle\ShortlinkBundle\Entity\Click;
use DPB\Bundle\ShortlinkBundle\Model\ClickManagerInterface;

class ClickManager implements ClickManagerInterface
{
    protected $em;
    protected $options;

    public function __construct(EntityManager $em, array $options)
    {
        $this->em = $em;
        $this->options = $options;
    }

    public function record(Request $request, Link $link)
    {
        $click = new Click();
        $click->setLink($link);
        $click->setIpAddress($request->getClientIp());
        $click->setUserAgent($request->headers->get('user-agent'));
        $click->setReferrer($request->headers->get('referer'));
        $click->setStatClickedAt(new DateTime());

        $this->em->persist($click);
        $this->em->flush();
    }
}
