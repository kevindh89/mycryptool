<?php

declare(strict_types=1);

namespace App\Exchange\Gdax;

use Psr\Log\LoggerInterface;

class Client
{
    private $requestBuilder;
    private $logger;

    public function __construct(RequestBuilder $requestBuilder, LoggerInterface $logger)
    {
        $this->requestBuilder = $requestBuilder;
        $this->logger = $logger;
    }

    public function getRate(string $currency = 'ETH-EUR'): array
    {
        $this->logger->info(sprintf('Executed GET request /products/%s/ticker in \App\Exchange\Gdax\Client', $currency));

        return $this->requestBuilder->request(
            'GET',
            sprintf('/products/%s/ticker', $currency)
        );
    }

    public function getOrders(): array
    {
        $this->logger->info('Executed GET request /orders in \App\Exchange\Gdax\Client');

        return $this->requestBuilder->request(
            'GET',
            '/orders'
        );
    }

    public function getTrades(): array
    {
        $this->logger->info('Executed GET request /fills in \App\Exchange\Gdax\Client');

        return $this->requestBuilder->request(
            'GET',
            '/fills'
        );
    }

    public function getTradesBefore(int $tradeId): array
    {
        $this->logger->info(sprintf('Executed GET request /fills?before=%s in \App\Exchange\Gdax\Client', $tradeId));

        return $this->requestBuilder->request(
            'GET',
            sprintf('/fills?before=%s', $tradeId)
        );
    }
}
