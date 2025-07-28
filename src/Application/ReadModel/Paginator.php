<?php

declare(strict_types=1);

namespace App\Application\ReadModel;

use App\Application\Exception\BadRequestException;

final readonly class Paginator
{
    public function __construct(
        private int $page,
        private ?int $limit = 5,
    ){}
    public function page(): int
    {
        $this->validatePage();
        return $this->page;
    }
    public function limit(): int
    {
        return $this->limit;
    }

    private function validatePage(): void
    {
        if ($this->page < 1) {
            throw new BadRequestException('Page must be greater than 0', ['page' => $this->page]);
        }
    }
}
