<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistance\Doctrine\Types;

use App\Domain\Model\Product\StockKeepingUnit;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class SkuType extends Type
{
    public function getName(): string
    {
        return 'sku';
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform-> getStringTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?StockKeepingUnit
    {
        return $value !== null ? StockKeepingUnit::from($value) : null;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {

        if ($value instanceof StockKeepingUnit) {
            return $value->getValue();
        }

        if (is_string($value)) {
            return StockKeepingUnit::from($value)->getValue();
        }

        return null;
    }
}
