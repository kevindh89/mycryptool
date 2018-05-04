<?php

declare(strict_types=1);

namespace App\Exchange\Gdax;

use App\Entity\Trade;
use App\Factory\TradeFactory;
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

    public function getRate(string $currency = 'ETH-EUR'): float
    {
        $this->logger->info(sprintf('Executed GET request /products/%s/ticker in \App\Exchange\Gdax\Client', $currency));
        $response = $this->requestBuilder->request(
            'GET',
            sprintf('/products/%s/ticker', $currency)
        );

        return (float) $response['price'];
    }

    public function getOrders(string $productId): array
    {
        $this->logger->info(sprintf('Executed GET request /orders?product_id=%s in \App\Exchange\Gdax\Client', $productId));

        return $this->requestBuilder->request(
            'GET',
            sprintf('/orders?product_id=%s', $productId)
        );
    }

    /**
     * @param string $productId
     *
     * @return Trade[]
     */
    public function getTrades(string $productId): array
    {
        $this->logger->info(sprintf('Executed GET request /fills?product_id=%s in \App\Exchange\Gdax\Client', $productId));

        $response = $this->requestBuilder->request(
            'GET',
            sprintf('/fills?product_id=%s', $productId)
        );

        return array_map(function (array $trade) {
            return TradeFactory::fromApiResponse($trade);
        }, $response);
    }

    public function getAccounts(): array
    {
        $this->logger->info('Executed GET request /accounts in \App\Exchange\Gdax\Client');

        return $this->requestBuilder->request(
            'GET',
            '/accounts'
        );
    }
}
