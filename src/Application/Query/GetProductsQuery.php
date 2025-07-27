<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Application\ReadModel\Paginator;

final readonly class GetProductsQuery
{

    public function __construct(
        private ?string $category = null,
        private ?int $priceLessThan = null,
        private Paginator $paginator
    ) {}

    public function category(): ?string
    {
        return $this->category;
    }

    public function priceLessThan(): ?int
    {
        return $this->priceLessThan;
    }

    public function paginator(): Paginator
    {
        return $this->paginator;
    }

}
