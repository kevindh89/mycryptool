<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;

class Trade
{
    private $tradeId;
    private $tradeCreatedAt;
    private $productId;
    private $orderId;
    private $userId;
    private $profileId;
    private $liquidity;
    private $price;
    private $size;
    private $fee;
    private $side;
    private $settled;

    public function __construct(
        int $tradeId,
        DateTime $createdAt,
        string $productId,
        string $orderId,
        string $userId,
        string $profileId,
        string $liquidity,
        float $price,
        float $size,
        float $fee,
        string $side,
        bool $settled
    ) {
        $this->tradeId = $tradeId;
        $this->tradeCreatedAt = $createdAt;
        $this->productId = $productId;
        $this->orderId = $orderId;
        $this->userId = $userId;
        $this->profileId = $profileId;
        $this->liquidity = $liquidity;
        $this->price = $price;
        $this->size = $size;
        $this->fee = $fee;
        $this->side = $side;
        $this->settled = $settled;
    }

    public function getTradeId(): int
    {
        return $this->tradeId;
    }

    public function setTradeId(int $tradeId)
    {
        $this->tradeId = $tradeId;
    }

    public function getTradeCreatedAt(): DateTime
    {
        return $this->tradeCreatedAt;
    }

    public function setTradeCreatedAt(DateTime $tradeCreatedAt)
    {
        $this->tradeCreatedAt = $tradeCreatedAt;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setProductId(string $productId)
    {
        $this->productId = $productId;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function setOrderId(string $orderId)
    {
        $this->orderId = $orderId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId)
    {
        $this->userId = $userId;
    }

    public function getProfileId(): string
    {
        return $this->profileId;
    }

    public function setProfileId(string $profileId)
    {
        $this->profileId = $profileId;
    }

    public function getLiquidity(): string
    {
        return $this->liquidity;
    }

    public function setLiquidity(string $liquidity)
    {
        $this->liquidity = $liquidity;
    }

    public function getPrice(): float
    {
        return (float) $this->price;
    }

    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    public function getSize(): float
    {
        return (float) $this->size;
    }

    public function setSize(float $size)
    {
        $this->size = $size;
    }

    public function getFee(): float
    {
        return (float) $this->fee;
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

    public function getSettled(): bool
    {
        return $this->settled;
    }

    public function setSettled(bool $settled)
    {
        $this->settled = $settled;
    }
}
