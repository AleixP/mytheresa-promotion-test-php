<?php

declare(strict_types=1);

namespace App\Application\ReadModel;

final readonly class Paginator
{
    public function __construct(
        private int $page,
        private ?int $limit = 5,
    ){}
    public function page(): int
    {
        return $this->page;
    }
    public function limit(): int
    {
        return $this->limit;
    }
}
