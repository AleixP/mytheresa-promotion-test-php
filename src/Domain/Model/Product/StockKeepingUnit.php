<?php

declare(strict_types=1);

namespace App\Domain\Model\Product;

use App\Domain\Shared\ValueObject;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class StockKeepingUnit extends ValueObject
{
    #[ORM\Column(name: "sku", type: "string", length: 255)]
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

