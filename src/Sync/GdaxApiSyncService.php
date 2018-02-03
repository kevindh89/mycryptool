<?php

declare(strict_types=1);

namespace App\Sync;

use App\Exchange\Gdax\Client;
use App\Factory\OrderFactory;
use App\Factory\TradeFactory;
use App\Repository\OrderRepository;
use App\Repository\TradeRepository;
use Doctrine\ORM\EntityManagerInterface;

class GdaxApiSyncService
{
    private $client;
    private $tradeRepository;
    private $orderRepository;
    private $entityManager;

    public function __construct(
        Client $client,
        TradeRepository $tradeRepository,
        OrderRepository $orderRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->client = $client;
        $this->tradeRepository = $tradeRepository;
        $this->orderRepository = $orderRepository;
        $this->entityManager = $entityManager;
    }

    public function fetchTrades(string $productId): int
    {
        $lastTradeId = $this->tradeRepository->getLastTradeIdForProduct($productId);

        $trades = $lastTradeId !== null ?
            $this->client->getTradesBefore($productId, $lastTradeId) :
            $this->client->getTrades($productId);

        foreach ($trades as $trade) {
            $this->entityManager->persist(TradeFactory::fromApiResponse($trade));
        }
        $this->entityManager->flush();

        return count($trades);
    }

    public function refreshOrders(string $productId): int
    {
        $this->entityManager
            ->createQuery('DELETE App\Entity\Order o WHERE o.productId = :productId')
            ->setParameter('productId', $productId)
            ->execute();

        return $this->fetchOrders($productId);
    }

    public function fetchOrders(string $productId): int
    {
        $orders = $this->client->getOrders($productId);

        foreach ($orders as $order) {
            $this->entityManager->persist(OrderFactory::fromApiResponse($order));
        }
        $this->entityManager->flush();

        return count($orders);
    }
}
