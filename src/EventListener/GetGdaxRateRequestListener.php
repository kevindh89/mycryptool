<?php

namespace App\EventListener;

use App\Exchange\Gdax\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class GetGdaxRateRequestListener
{
    private $client;
    private $session;
    private $logger;

    public function __construct(Client $client, SessionInterface $session, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->session = $session;
        $this->logger = $logger;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if (!$event->isMasterRequest() || substr_count($event->getRequest()->getRequestUri(), 'api') > 0) {
            $this->logger->info('Skipped GetGdaxRateRequestListener');

            return;
        }

        $rate = $this->client->getRate('ETH-EUR');
        $this->session->set('rate', $rate);
    }
}
