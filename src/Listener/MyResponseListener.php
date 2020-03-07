<?php

namespace App\Listener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class MyResponseListener
{
    public function onKernelResponse(ResponseEvent $event)
    {
        //$event->setResponse(new Response('asd'));
    }
}
