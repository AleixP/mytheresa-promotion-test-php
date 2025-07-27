<?php

declare(strict_types=1);

namespace App\Domain\Model\Product;


use App\Domain\Model\Price\Price;

interface ProductRepository
{
    public function saveWithPrice(Product $product, Price $price): void;

    public function findByFilters(array $filters, int $offset, ?int $limit = 5): array;
}
