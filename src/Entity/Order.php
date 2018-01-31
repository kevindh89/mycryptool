<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="trade_order")
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $orderId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $orderCreatedAt;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $productId;

    /**
     * @ORM\Column(type="decimal", precision=24, scale=8)
     */
    private $price;

    /**
     * @ORM\Column(type="decimal", precision=24, scale=8)
     */
    private $size;

    /**
     * @ORM\Column(type="string")
     */
    private $side;

    /**
     * @ORM\Column(type="boolean")
     */
    private $settled;

    /**
     * @ORM\Column(type="decimal", precision=24, scale=12)
     */
    private $fillFees;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $stp;

    /**
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @ORM\Column(type="string")
     */
    private $timeInForce;

    /**
     * @ORM\Column(type="decimal", precision=24, scale=8)
     */
    private $filledSize;

    /**
     * @ORM\Column(type="decimal", precision=24, scale=12)
     */
    private $executedValue;

    /**
     * @ORM\Column(type="string")
     */
    private $status;

    public function __construct(
        string $orderId,
        DateTime $createdAt,
        string $productId,
        float $price,
        float $size,
        float $fillFees,
        string $side,
        bool $settled,
        string $stp,
        string $type,
        string $timeInForce,
        float $filledSize,
        float $executedValue,
        string $status
    ) {
        $this->orderId = $orderId;
        $this->orderCreatedAt = $createdAt;
        $this->productId = $productId;
        $this->price = $price;
        $this->size = $size;
        $this->side = $side;
        $this->settled = $settled;
        $this->fillFees = $fillFees;
        $this->stp = $stp;
        $this->type = $type;
        $this->timeInForce = $timeInForce;
        $this->filledSize = $filledSize;
        $this->executedValue = $executedValue;
        $this->status = $status;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getOrderCreatedAt(): DateTime
    {
        return $this->orderCreatedAt;
    }

    public function setOrderCreatedAt(DateTime $orderCreatedAt): void
    {
        $this->orderCreatedAt = $orderCreatedAt;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }

    public function getPrice(): float
    {
        return (float) $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getSize(): float
    {
        return (float) $this->size;
    }

    public function setSize(float $size): void
    {
        $this->size = $size;
    }

    public function getSide(): string
    {
        return $this->side;
    }

    public function setSide(string $side): void
    {
        $this->side = $side;
    }

    public function getSettled(): bool
    {
        return $this->settled;
    }

    public function setSettled(bool $settled): void
    {
        $this->settled = $settled;
    }

    public function getFillFees(): float
    {
        return (float) $this->fillFees;
    }

    public function setFillFees(float $fillFees): void
    {
        $this->fillFees = $fillFees;
    }

    public function getStp(): string
    {
        return $this->stp;
    }

    public function setStp(string $stp): void
    {
        $this->stp = $stp;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getTimeInForce(): string
    {
        return $this->timeInForce;
    }

    public function setTimeInForce(string $timeInForce): void
    {
        $this->timeInForce = $timeInForce;
    }

    public function getFilledSize(): float
    {
        return (float) $this->filledSize;
    }

    public function setFilledSize(float $filledSize): void
    {
        $this->filledSize = $filledSize;
    }

    public function getExecutedValue(): float
    {
        return (float) $this->executedValue;
    }

    public function setExecutedValue(float $executedValue): void
    {
        $this->executedValue = $executedValue;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
