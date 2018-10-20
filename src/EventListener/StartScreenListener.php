<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class StartScreenListener
{
    private $session;
    private $twig;
    private $logger;

    public function __construct(SessionInterface $session, \Twig_Environment $twig, LoggerInterface $logger)
    {
        $this->session = $session;
        $this->twig = $twig;
        $this->logger = $logger;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest() || substr_count($event->getRequest()->getRequestUri(), 'api') > 0) {
            $this->logger->info('Skipped StartScreenListener');

            return;
        }

        if ($event->getRequest()->request->get('start-capital')) {
            $this->session->set('startCapital', $event->getRequest()->request->get('start-capital'));
        }

        if (!$this->session->has('startCapital')) {
            $event->setResponse(new Response($this->twig->render('start_screen/setup.html.twig')));
        }
    }
}
