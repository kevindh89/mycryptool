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

    public function getOrders(string $productId): array
    {
        $this->logger->info(sprintf('Executed GET request /orders?product_id=%s in \App\Exchange\Gdax\Client', $productId));

        return $this->requestBuilder->request(
            'GET',
            sprintf('/orders?product_id=%s', $productId)
        );
    }

    public function getTrades(string $productId): array
    {
        $this->logger->info(sprintf('Executed GET request /fills?product_id=%s in \App\Exchange\Gdax\Client', $productId));

        return $this->requestBuilder->request(
            'GET',
            sprintf('/fills?product_id=%s', $productId)
        );
    }

    public function getTradesBefore(string $productId, int $tradeId): array
    {
        $this->logger->info(sprintf('Executed GET request /fills?product_id=%s&before=%s in \App\Exchange\Gdax\Client', $productId, $tradeId));

        return $this->requestBuilder->request(
            'GET',
            sprintf('/fills?product_id=%s&before=%s', $productId, $tradeId)
        );
    }
}
