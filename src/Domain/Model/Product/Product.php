<?php

declare(strict_types=1);

namespace App\Domain\Model\Product;

use App\Domain\Model\Price\Price;
use App\Domain\Shared\AggregateRoot;

final class Product extends AggregateRoot
{
    private readonly int $id;

    private function __construct(
        private string              $name,
        private StockKeepingUnit    $stockKeepingUnit,
        private Category            $category,
        private Price               $price,
        private readonly ?\DateTime $createdAt = null,
        private readonly ?\DateTime $updatedAt = null,
    ){}

    public static function create(
        string           $name,
        StockKeepingUnit $stockKeepingUnit,
        Category         $category,
        Price            $price,
    ): self
    {
        return new self($name, $stockKeepingUnit, $category, $price);
    }


    public function id(): int
    {
        return $this->id;
    }
    public function name(): string
    {
        return $this->name;
    }
    public function sku(): StockKeepingUnit
    {
        return $this->stockKeepingUnit;
    }
    public function category(): Category
    {
        return $this->category;
    }

    public function price(): Price
    {
        return $this->price;
    }

    public function createdAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTime
    {
        return $this->updatedAt;
    }


}
