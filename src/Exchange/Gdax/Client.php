<?php

declare(strict_types=1);

namespace App\Exchange\Gdax;

use App\Exchange\GdaxExchange;
use GuzzleHttp\Psr7\Response;

class Client
{
    private $requestBuilder;

    public function __construct(RequestBuilder $requestBuilder)
    {
        $this->requestBuilder = $requestBuilder;
    }

    public function getRate(string $currency = 'ETH-EUR'): array
    {
        return $this->requestBuilder->request(
            'GET',
            sprintf('/products/%s/ticker', $currency)
        );
    }

    public function getOrders(): array
    {
        return $this->requestBuilder->request(
            'GET',
            '/orders'
        );
    }

    public function getTrades(): array
    {
        return $this->requestBuilder->request(
            'GET',
            '/fills'
        );
    }

    public function getTradesBefore(int $tradeId): array
    {
        return $this->requestBuilder->request(
            'GET',
            sprintf('/fills?before=%s', $tradeId)
        );
    }
}
