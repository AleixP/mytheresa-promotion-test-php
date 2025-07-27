<?php

declare(strict_types=1);

namespace App\Domain\Model\Product;

use App\Domain\Shared\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;

class Product extends AggregateRoot
{
    private readonly int $id;

    private function __construct(
        private string              $name,
        #[ORM\Embedded(class: StockKeepingUnit::class)]
        private StockKeepingUnit    $stockKeepingUnit,
        private Category            $category,
        private readonly \DateTime $createdAt,
        private \DateTime $updatedAt,
    ){}

    public static function createFromPrimitives(
        string $name,
        string $stockKeepingUnit,
        string $category
    ): self
    {
        $now = new \DateTime();
        return new self(
            $name,
            StockKeepingUnit::from($stockKeepingUnit),
            Category::from($category),
            $now,
            $now
        );
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

    public function createdAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

}
