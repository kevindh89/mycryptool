<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="account")
 * @ORM\Entity()
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=24, scale=8)
     */
    private $startCapital;

    public function __construct(string $id, float $startCapital)
    {
        $this->id = $id;
        $this->startCapital = $startCapital;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStartCapital(): float
    {
        return (float) $this->startCapital;
    }

    public function setStartCapital(float $startCapital)
    {
        $this->startCapital = $startCapital;
    }
}
