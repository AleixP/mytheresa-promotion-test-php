<?php

declare(strict_types=1);

namespace App\Domain\Model\Promotion;

use App\Domain\Shared\Entity;

final class Promotion extends Entity
{

    private readonly int $id;

    private function __construct(
        private PromotionType $promotionType,
        private string $applicableTo,
        private int $percentage,
        private readonly ?\DateTime $createdAt = null,
        private ?\DateTime $updatedAt = null,
    ){}

    public static function createFromPrimitives(string $promotionType, string $applicableTo, int $percentage): self
    {
        $now = new \DateTime();
        return new self(
            PromotionType::from($promotionType),
            $applicableTo,
            $percentage,
            $now,
            $now
        );
    }
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
