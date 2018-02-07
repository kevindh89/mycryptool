<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Trade;
use App\Model\GroupedTrade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TradeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Trade::class);
    }

    public function getLastTradeIdForProduct(string $productId): ?int
    {
        $lastTrade = $this->findOneBy(['productId' => $productId], ['tradeId' => 'DESC']);

        return $lastTrade !== null ? $lastTrade->getTradeId() : null;
    }

    /**
     * @param string $productId
     *
     * @return GroupedTrade[]
     */
    public function getGroupedTrades(string $productId): array
    {
        $query = $this->createQueryBuilder('t')
            ->select('NEW App\Model\GroupedTrade(t.orderId, t.productId, AVG(t.price), SUM(t.size), MAX(t.tradeCreatedAt), SUM(t.fee), t.side)')
            ->where('t.productId = :productId')
            ->groupBy('t.orderId, t.side')
            ->orderBy('MAX(t.tradeCreatedAt)', 'DESC')
            ->setParameter('productId', $productId)
            ->getQuery();

        return $query->getResult();
    }
}
