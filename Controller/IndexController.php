<?php

namespace DPB\Bundle\ShortlinkBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IndexController extends ContainerAware
{
    public function indexAction() {
        $redirect = $this->container->getParameter('dpb_shortlink.root');

        if (null === $redirect) {
            throw new NotFoundHttpException('A root link is not available (configure dpb_shortlink.root).');
        }

        return new RedirectResponse($redirect);
    }
}
