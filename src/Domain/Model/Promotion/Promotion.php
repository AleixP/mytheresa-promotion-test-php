<?php

declare(strict_types=1);

namespace App\Domain\Model\Promotion;

use App\Domain\Shared\Entity;

final class Promotion extends Entity
{

    private readonly int $id;

    private function __construct(
        int $id,
        private PromotionType $promotionType,
        private string $applicableTo,
        private int $percentage,
        private readonly ?\DateTime $createdAt = null,
        private readonly ?\DateTime $updatedAt = null,
    ){}

    public function id(): int
    {
        return $this->id;
    }

    public function promotionType(): PromotionType
    {
        return $this->promotionType;
    }

    public function applicableTo(): string
    {
        return $this->applicableTo;
    }

    public function percentage(): int
    {
        return $this->percentage;
    }



}
