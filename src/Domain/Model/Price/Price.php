<?php

declare(strict_types=1);

namespace App\Domain\Model\Price;

use App\Domain\Model\Product\StockKeepingUnit;
use App\Domain\Shared\Entity;

final class Price extends Entity
{
    private readonly int $id;
    private function __construct(
        private StockKeepingUnit $stockKeepingUnit,
        private int $price,
        private Currency  $currency,
        private readonly ?\DateTime $createdAt = null
    ){}

    public function id(): int
    {
        return $this->id;
    }
    public function price(): int
    {
        return $this->price;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function stockKeepingUnit(): StockKeepingUnit
    {
        return $this->stockKeepingUnit;
    }

   /** public static function create(): self
    {
        return new self($id, $stockKeepingUnit, $price, $currency
        );
    } */
}
