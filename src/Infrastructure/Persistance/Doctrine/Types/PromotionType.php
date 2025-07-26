<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistance\Doctrine\Types;

use App\Domain\Model\Promotion\PromotionType as PromotionTypeEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class PromotionType extends StringType
{
    public function getName(): string
    {
        return 'promotion_type';
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {

        $cases = 'ENUM(';

        array_filter(PromotionTypeEnum::cases(), function ($case) use (&$cases) {
            return $cases .= '\''.$case->value . '\' , ';
        });

        return substr_replace($cases, '',  -2) . ')';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?PromotionTypeEnum
    {
        return PromotionTypeEnum::from($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof PromotionTypeEnum) {
            return $value->value;
        }

        if (is_string($value)) {
            return PromotionTypeEnum::from($value)->value;
        }
        return null;
    }
}
