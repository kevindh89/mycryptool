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
        $response = $this->requestBuilder->request('GET', sprintf('/products/%s/ticker', $currency));
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getOrders(): array
    {
        $response = $this->requestBuilder->request(
            'GET',
            '/orders'
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getTrades(): array
    {
        $response = $this->requestBuilder->request(
            'GET',
            '/fills'
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getTradesBefore(int $tradeId): array
    {
        $response = $this->requestBuilder->request(
            'GET',
            sprintf('/fills?before=%s', $tradeId)
        );
        return json_decode($response->getBody()->getContents(), true);
    }
}
