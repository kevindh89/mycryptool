<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exchange\Gdax\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class ApiController
{
    /**
     * @Route("/rate/{product}", name="rates")
     */
    public function rates(string $product, Client $client): Response
    {
        return new Response($client->getRate($product));
    }
}
