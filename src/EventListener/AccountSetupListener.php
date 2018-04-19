<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\Router;

class AccountSetupListener
{
    private $router;
    private $entityManager;

    public function __construct(EntityManager $entityManager, Router $router)
    {
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    public function onKernelRequest(GetResponseEvent $event): bool
    {
        $account = $this
            ->entityManager
            ->getRepository('App\Entity\Account')
            ->find(getenv('GDAX_API_KEY'));

        $accountSetupUri = $this->router->generate('account_setup');
        if (!$account && $event->getRequest()->getRequestUri() !== $accountSetupUri) {
            $event->setResponse(new RedirectResponse($accountSetupUri));

            return true;
        }

        return false;
    }
}
