<?php

declare(strict_types=1);

namespace App\Exchange\Gdax;

use App\Entity\Trade;
use App\Factory\TradeFactory;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\RouterInterface;

class Client
{
    const API_BASE_URI = 'https://api.gdax.com';

    private $requestBuilder;
    private $logger;
    private $client;
    private $router;

    public function __construct(
        \GuzzleHttp\Client $client,
        RequestBuilder $requestBuilder,
        LoggerInterface $logger,
        RouterInterface $router
    ) {
        $this->requestBuilder = $requestBuilder;
        $this->logger = $logger;
        $this->client = $client;
        $this->router = $router;
    }

    public function getRate(string $currency = 'ETH-EUR'): float
    {
        $this->logger->info(sprintf('Executed GET request /products/%s/ticker in \App\Exchange\Gdax\Client', $currency));
        $endpoint = sprintf('/products/%s/ticker', $currency);

        $response = $this->client
            ->request(
                'GET',
                self::API_BASE_URI . $endpoint,
                $this->requestBuilder->build('GET', $endpoint)
            )
            ->getBody()
            ->getContents();

        return (float) json_decode($response, true)['price'];
    }

    public function getOrders(string $productId): array
    {
        $this->logger->info(sprintf('Executed GET request /or$ders?product_id=%s in \App\Exchange\Gdax\Client', $productId));
        $endpoint = sprintf('/orders?product_id=%s', $productId);

        $response = $this->client
            ->request(
                'GET',
                self::API_BASE_URI . $endpoint,
                $this->requestBuilder->build('GET', $endpoint)
            )
            ->getBody()
            ->getContents();

        return json_decode($response, true);
    }

    /**
     * @param string $productId
     *
     * @return Trade[]
     */
    public function getTrades(string $productId): array
    {
        $this->logger->info(sprintf('Executed GET request /fills?product_id=%s in \App\Exchange\Gdax\Client', $productId));
        $endpoint = sprintf('/fills?product_id=%s', $productId);

        $response = $this->client
            ->request(
                'GET',
                self::API_BASE_URI . $endpoint,
                $this->requestBuilder->build('GET', $endpoint)
            )
            ->getBody()
            ->getContents();

        return array_map(function (array $trade) {
            return TradeFactory::fromApiResponse($trade);
        }, json_decode($response, true));
    }

    public function getAccounts(): array
    {
        $this->logger->info('Executed GET request /accounts in \App\Exchange\Gdax\Client');
        $endpoint = '/accounts';

        $response = $this->client
            ->request(
                'GET',
                self::API_BASE_URI . $endpoint,
                $this->requestBuilder->build('GET', $endpoint)
            )
            ->getBody()
            ->getContents();

        return json_decode($response, true);
    }
}
