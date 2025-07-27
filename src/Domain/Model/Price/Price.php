<?php

declare(strict_types=1);

namespace App\Domain\Model\Price;

use App\Domain\Shared\Entity;

final class Price extends Entity
{
    private readonly int $id;

    private function __construct(
        private string $sku,
        private int $price,
        private Currency  $currency,
        private readonly ?\DateTime $createdAt
    ){}

    public function id(): int
    {
        return $this->id;
    }
    public function price(): int
    {
        return $this->price;
    }
    public function sku(): string
    {
        return $this->sku;
    }
    public function currency(): Currency
    {
        return $this->currency;
    }


   public static function createFromPrimitives(string $sku, int $price, ?string $currency = null): self
    {
        $now = new \DateTime();
        return new self(
            $sku,
            $price,
            Currency::from($currency),
            $now
        );
    }

}
