<?php

declare(strict_types=1);

namespace App\Application\Query;

final readonly class GetProductsQuery
{

    public function __construct(
        private ?string $category = null,
        private ?int $priceLessThan = null,
        private ?int $page = null,
    ) {}

    public function category(): ?string
    {
        return $this->category;
    }

    public function priceLessThan(): ?int
    {
        return $this->priceLessThan;
    }

    public function page(): ?int
    {
        return $this->page;
    }

}
