<?php

namespace DPB\Bundle\ShortlinkBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Yaml\Yaml;
use DPB\Bundle\ShortlinkBundle\Entity\Link;

class ApiLinkController extends ContainerAware
{
    public function createAction(Request $request, $_format) {
        $this->requireRole('ROLE_DPB_SHORTLINK_CREATE');

        if (!$request->request->has('url')) {
            throw new HttpException(400, 'Request is missing `url`.');
        }

        $link = $this->container->get('dpb_shortlink.link_manager')->create($request->request->get('url'));

        return $this->createLinkResponse($request, $link);
    }

    public function createuniqueAction(Request $request, $_format) {
        $this->requireRole('ROLE_DPB_SHORTLINK_CREATE');

        if (!$request->request->has('url')) {
            throw new HttpException(400, 'Request is missing `url`.');
        }

        $link = $this->container->get('dpb_shortlink.link_manager')->createUnique($request->request->get('url'));

        return $this->createLinkResponse($request, $link);
    }

    protected function createLinkResponse(Request $request, Link $link)
    {
        if (!$request->attributes->get('_format')) {
            return new Response(
                '',
                201,
                array(
                    'Location' => $this->container->get('router')->generate('dpb_shortlink_link_click', array('code' => $link->getCode()), true),
                )
            );
        }

        return new Response(
            $this->container->get('jms_serializer')->serialize(
                array(
                    'code' => $link->getCode(),
                    'url' => $this->container->get('router')->generate('dpb_shortlink_link_click', array('code' => $link->getCode()), true),
                    'stat_created_at' => $link->getStatCreatedAt(),
                    'stat_created_by' => $link->getStatCreatedBy(),
                ),
                $request->attributes->get('_format')
            ),
            201,
            array(
                'content-type' => $request->getRequestFormat(),
            )
        );
    }

    protected function requireRole($role) {
        if (!$this->container->get('security.context')->isGranted('ROLE_DPB_SHORTLINK_CREATE')) {
            throw new AccessDeniedHttpException();
        }
    }
}
