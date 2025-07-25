<?php

declare(strict_types=1);

namespace App\Domain\Model\Price;

use App\Domain\Shared\ValueObject;

final class Currency extends ValueObject
{
    public const EUR = 'EUR';
    public const DEFAULT = self::EUR;
    private const VALID_OPTIONS = [
        self::EUR,
    ];
    private string $value;

    public function __construct(?string $value = null)
    {
        self::validateValue($value);
        $this->value = $value ?: self::DEFAULT;
    }

    private static function validateValue(string $value)
    {
        if (!in_array($value, self::VALID_OPTIONS)) {
            throw new \InvalidArgumentException(sprintf('Currency %s is not valid', $value));
        }
    }

    protected function hasSameValues(object $other): bool
    {
        return $this->value() === $other->value();
    }

    public function value(): string
    {
        return $this->value;
    }
}
