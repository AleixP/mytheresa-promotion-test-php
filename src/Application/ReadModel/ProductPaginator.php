<?php

declare(strict_types=1);

namespace App\Application\ReadModel;

use App\Domain\Model\Product\Product as DomainProduct;
use App\Domain\Model\Promotion\Promotion as DomainPromotion;
use App\Domain\Model\Price\Price as DomainPrice;

final readonly class ProductPaginator
{
    public function __construct(
        public array $data,
        public int $total,
        public int $page,
        public int $limit
    ) {}

    public function data(): array
    {
        return $this->data;
    }
    public function total() : int
    {
        return $this->total;
    }
    public function page() : int
    {
        return $this->page;
    }
    public function limit() : int
    {
        return $this->limit;
    }
}
