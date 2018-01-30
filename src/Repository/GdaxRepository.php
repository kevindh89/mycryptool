<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exchange\GdaxExchange;
use GuzzleHttp\Psr7\Response;

class GdaxRepository
{
    private $gdaxExchange;

    public function __construct(GdaxExchange $gdaxExchange)
    {
        $this->gdaxExchange = $gdaxExchange;
    }

    public function getRate(string $currency = 'ETH-EUR'): Response
    {
        return $this->gdaxExchange->request('GET', sprintf('/products/%s/ticker', $currency));
    }

    public function getOrders(): Response
    {
        return $this->gdaxExchange->request('GET', '/orders');
    }

    public function getFillsBefore(int $tradeId): Response
    {
        return $this->gdaxExchange->request(
            'GET',
            sprintf('/fills?before=%s', $tradeId)
        );
    }

    public function getFills(): Response
    {
        return $this->gdaxExchange->request(
            'GET',
            '/fills'
        );
    }
}
