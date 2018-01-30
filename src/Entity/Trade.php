<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TradeRepository")
 */
class Trade
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $tradeId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $tradeCreatedAt;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $productId;

    /**
     * @ORM\Column(type="string")
     */
    private $orderId;

    /**
     * @ORM\Column(type="string")
     */
    private $userId;

    /**
     * @ORM\Column(type="string")
     */
    private $profileId;

    /**
     * @ORM\Column(type="string")
     */
    private $liquidity;

    /**
     * @ORM\Column(type="decimal", precision=24, scale=8)
     */
    private $price;

    /**
     * @ORM\Column(type="decimal", precision=24, scale=8)
     */
    private $size;

    /**
     * @ORM\Column(type="decimal", precision=24, scale=16)
     */
    private $fee;

    /**
     * @ORM\Column(type="string")
     */
    private $side;

    /**
     * @ORM\Column(type="boolean")
     */
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
        $this->tradeId =    $tradeId;
        $this->tradeCreatedAt =  $createdAt;
        $this->productId =  $productId;
        $this->orderId =    $orderId;
        $this->userId =     $userId;
        $this->profileId =  $profileId;
        $this->liquidity =  $liquidity;
        $this->price =      $price;
        $this->size =       $size;
        $this->fee =        $fee;
        $this->side =       $side;
        $this->settled =    $settled;
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
        return $this->price;
    }

    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    public function getSize(): float
    {
        return $this->size;
    }

    public function setSize(float $size)
    {
        $this->size = $size;
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

    public function getSettled(): bool
    {
        return $this->settled;
    }

    public function setSettled(bool $settled)
    {
        $this->settled = $settled;
    }
}
