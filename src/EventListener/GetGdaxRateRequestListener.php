<?php

namespace App\EventListener;

use App\Exchange\Gdax\Client;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class GetGdaxRateRequestListener
{
    private $client;
    private $session;

    public function __construct(Client $client, SessionInterface $session)
    {
        $this->client = $client;
        $this->session = $session;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $rate = $this->client->getRate('ETH-EUR');
        $this->session->set('rate', $rate);
    }
}
