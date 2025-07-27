<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistance\Doctrine\Types;

use App\Domain\Model\Price\Currency;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class CurrencyType extends Type
{
    public function getName(): string
    {
        return 'currency';
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform-> getStringTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Currency
    {
        return $value !== null ? Currency::from($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof Currency) {
            return $value->value();
        }

        if (is_string($value)) {
            return Currency::from($value)->value();
        }
        return null;
    }
}
