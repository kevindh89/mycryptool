<?php

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

    public function getLastTradeId(): ?int
    {
        $lastTrade = $this->findOneBy([], ['tradeId' => 'DESC']);

        return $lastTrade !== null ? $lastTrade->getTradeId() : null;
    }
}
