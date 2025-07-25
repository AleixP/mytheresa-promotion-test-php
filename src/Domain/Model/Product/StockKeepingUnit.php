<?php

declare(strict_types=1);

namespace App\Domain\Model\Product;

use App\Domain\Shared\ValueObject;

final class StockKeepingUnit extends ValueObject
{
    private string $value;

    public function __construct(string $value)
    {
        self::validateValue($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function validateValue(string $value): void
    {
        // Add format validation if needed
    }

    protected function hasSameValues(object $other): bool
    {
        return $this->value === $other->getValue();
    }
}

