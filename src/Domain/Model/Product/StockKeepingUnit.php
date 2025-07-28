<?php

declare(strict_types=1);

namespace App\Domain\Model\Product;

use App\Domain\Shared\ValueObject;

class StockKeepingUnit extends ValueObject
{
    private string $value;

    private function __construct(string $value)
    {
        self::validateValue($value);
        $this->value = $value;
    }

    public static function from(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->getValue();
    }

    public function getValue(): string
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

