<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exchange\GdaxExchange;
use App\Repository\GdaxRepository;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class ApiController
{
    /**
     * @Route("/rates", name="rates")
     */
    public function rates(GdaxRepository $gdaxRepository): Response
    {
        $response = $gdaxRepository->getRate('ETH-EUR')->getBody()->getContents();
        return new Response(
            '<pre>'. json_encode(json_decode($response), JSON_PRETTY_PRINT) .'</pre>'
        );
    }

    /**
     * @Route("/orders", name="orders")
     */
    public function trades(GdaxRepository $gdaxRepository): Response
    {
        $response = $gdaxRepository->getOrders()->getBody()->getContents();
        return new Response(
            '<pre>'. json_encode(json_decode($response), JSON_PRETTY_PRINT) .'</pre>'
        );
    }
}