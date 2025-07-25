<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistance\Doctrine\Types;

use App\Domain\Model\Product\StockKeepingUnit;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

class SkuType extends JsonType
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
        return $value !== null ? new StockKeepingUnit($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof StockKeepingUnit ? (string) $value : null;
    }
}
