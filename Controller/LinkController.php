<?php

namespace DPB\Bundle\ShortlinkBundle\Controller;

use QRcode;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LinkController extends ContainerAware
{
    public function clickAction(Request $request, $code) {
        $link = $this->requireLink($code);

        $this->container->get('dpb_shortlink.click_manager')->record($request, $link);

        return new RedirectResponse($link->getUrl());
    }

    public function urltxtAction(Request $request, $code) {
        $link = $this->requireLink($code);

        return new Response(
            $link->getUrl(),
            200,
            array(
                'content-type' => 'text/plain',
            )
        );

        return new RedirectResponse($link->getUrl());
    }

    public function qrcodeAction(Request $request, $code) {
        if (!file_exists(__DIR__ . '/../Resources/vendor/phpqrcode/qrlib.php')) {
            throw new NotFoundHttpException('The phpqrcode library is not available.');
        }

        require_once __DIR__ . '/../Resources/vendor/phpqrcode/qrlib.php';

        $link = $this->requireLink($code);

        switch ($request->query->get('ec')) {
            case 'l':
                $ec = \QR_ECLEVEL_L;

                break;
            case 'm':
                $ec = \QR_ECLEVEL_M;

                break;
            case 'q':
                $ec = \QR_ECLEVEL_Q;

                break;
            case 'h':
                $ec = \QR_ECLEVEL_H;

                break;
            default:
                $ec = \QR_ECLEVEL_L;
        }

        ob_start();

        QRcode::png(
            $this->container->get('router')->generate(
                'dpb_shortlink_link_click',
                array(
                    'code' => $code,
                ),
                true
            ),
            false,
            $ec,
            $request->query->get('s', 3),
            0
        );

        return new Response(
            ob_get_end(),
            200,
            array(
                'Content-Type' => 'image/png',
            )
        );
    }

    public function requireLink($code)
    {
        $link = $this->container->get('dpb_shortlink.link_manager')->lookup($code);

        if (null === $link) {
            throw new NotFoundHttpException('Code not found.');
        } elseif ($link->getStatDeletedAt()) {
            throw new HttpException(410, 'Code has been deleted.');
        }

        return $link;
    }
}
