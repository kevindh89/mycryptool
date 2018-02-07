<?php

declare(strict_types=1);

namespace App\Cryptool;

class GroupedTrade
{
    private $productId;
    private $averagePrice;
    private $size;
    private $tradeCreatedAt;
    private $fee;
    private $side;
    /**
     * @var string
     */
    private $orderId;

    public function __construct(string $orderId, string $productId, float $averagePrice, float $size, string $tradeCreatedAt, float $fee, string $side)
    {
        $this->productId = $productId;
        $this->averagePrice = $averagePrice;
        $this->size = $size;
        $this->tradeCreatedAt = new \DateTime($tradeCreatedAt);
        $this->fee = $fee;
        $this->side = $side;
        $this->orderId = $orderId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setProductId(string $productId)
    {
        $this->productId = $productId;
    }

    public function getAveragePrice(): float
    {
        return $this->averagePrice;
    }

    public function setAveragePrice(float $averagePrice)
    {
        $this->averagePrice = $averagePrice;
    }

    public function getSize(): float
    {
        return $this->size;
    }

    public function setSize(float $size)
    {
        $this->size = $size;
    }

    public function getTradeCreatedAt(): \DateTime
    {
        return $this->tradeCreatedAt;
    }

    public function setTradeCreatedAt(\DateTime $tradeCreatedAt)
    {
        $this->tradeCreatedAt = $tradeCreatedAt;
    }

    public function getFee(): float
    {
        return $this->fee;
    }

    public function setFee(float $fee)
    {
        $this->fee = $fee;
    }

    public function getSide(): string
    {
        return $this->side;
    }

    public function setSide(string $side)
    {
        $this->side = $side;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function setOrderId(string $orderId)
    {
        $this->orderId = $orderId;
    }
}
