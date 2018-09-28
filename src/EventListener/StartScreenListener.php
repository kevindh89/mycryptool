<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class StartScreenListener
{
    private $session;
    private $twig;

    public function __construct(SessionInterface $session, \Twig_Environment $twig)
    {
        $this->session = $session;
        $this->twig = $twig;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($event->getRequest()->request->get('start-capital')) {
            $this->session->set('startCapital', $event->getRequest()->request->get('start-capital'));
        }

        if (!$this->session->has('startCapital')) {
            $event->setResponse(new Response($this->twig->render('start_screen/setup.html.twig')));
        }
    }
}
