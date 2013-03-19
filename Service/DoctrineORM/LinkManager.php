<?php

namespace DPB\Bundle\ShortlinkBundle\Service\DoctrineORM;

use DateTime;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContextInterface;
use DPB\Bundle\ShortlinkBundle\Entity\Link;
use DPB\Bundle\ShortlinkBundle\Model\LinkManagerInterface;

class LinkManager implements LinkManagerInterface
{
    protected $em;
    protected $options;

    public function __construct(EntityManager $em, $er, SecurityContextInterface $securityContext, array $options)
    {
        $this->em = $em;
        $this->er = $er;
        $this->securityContext = $securityContext;
        $this->options = $options;
    }

    public function create($url)
    {
        if (null !== $link = $this->lookupUrl($url)) {
            return $link;
        }

        return $this->createUnique($url);
    }

    public function createUnique($url)
    {
        $token = $this->securityContext->getToken();

        $link = new Link();
        $link->setUrl($url);
        $link->setStatCreatedAt(new DateTime());
        $link->setStatCreatedBy($token ? $token->getUsername() : 'anon.');

        for ($i = 0; $i < 16; $i += 1) {
            $link->setCode($this->generateCode());

            $this->em->persist($link);

            try {
                $this->em->flush();

                return $link;
            } catch (\Exception $e) {
                throw $e;
            }
        }

        throw new \RuntimeException('Attempt exceeded.');
    }

    public function lookup($code)
    {
        return $this->em->getRepository($this->er)->find($code);
    }

    public function lookupUrl($url)
    {
        return $this->em->getRepository($this->er)->findOneBy(
            array(
                'url' => $url,
                'statDeletedAt' => null,
            )
        );
    }

    protected function generateCode()
    {
        $code = '';
        $chrlen = strlen($this->options['characters']) - 1;
        $deflen = $this->options['default_length'];

        for ($i = 0; $i < $deflen; $i += 1) {
            $code .= $this->options['characters'][rand(0, $chrlen)];
        }

        return $code;
    }
}
