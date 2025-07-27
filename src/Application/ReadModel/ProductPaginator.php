<?php

declare(strict_types=1);

namespace App\Application\ReadModel;

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
