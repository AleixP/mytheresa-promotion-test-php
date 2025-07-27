<?php

declare(strict_types=1);

namespace App\Domain\Model\Promotion;

interface PromotionRepository
{
    public function save(Promotion $promotion): void;
    public function findByFilters(array $filters): array;
}
