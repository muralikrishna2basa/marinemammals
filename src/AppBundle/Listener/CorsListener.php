<?php
namespace AppBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class CorsListener
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
        //actually not needed as we don't provide fonts etc.
        //$responseHeaders = $event->getResponse()->headers;

        //$responseHeaders->set('Access-Control-Allow-Headers', 'origin, content-type, accept');
        //$responseHeaders->set('Access-Control-Allow-Origin', 'http://fonts.gstatic.com');
        //$responseHeaders->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');
    }
}