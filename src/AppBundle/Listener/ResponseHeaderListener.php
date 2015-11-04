<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 29.10.15
 * Time: 12:04
 */

namespace AppBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ResponseHeaderListener {

    public function onKernelResponse(FilterResponseEvent $event)
    {
        //$responseHeaders = $event->getResponse()->headers;

        //$responseHeaders->set('Content-Type', 'text/css; charset=utf-8 ');
    }

    /*
        app.response_header_listener:
        class:      AppBundle\Listener\ResponseHeaderListener
        tags:
            - { name: kernel.event_listener, event: kernel.response, method: onKernelResponse }
     */
}