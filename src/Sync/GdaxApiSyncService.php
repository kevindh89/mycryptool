<?php

declare(strict_types=1);

namespace App\Sync;

use App\Exchange\Gdax\Client;
use App\Factory\TradeFactory;
use App\Repository\TradeRepository;
use Doctrine\ORM\EntityManagerInterface;

class GdaxApiSyncService
{
    private $client;
    private $tradeRepository;
    private $entityManager;

    public function __construct(
        Client $client,
        TradeRepository $tradeRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->client = $client;
        $this->tradeRepository = $tradeRepository;
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
}
