<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Trade;
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
}
