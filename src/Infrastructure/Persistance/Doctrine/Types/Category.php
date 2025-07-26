<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistance\Doctrine\Types;

use App\Domain\Model\Product\Category as CategoryEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class Category extends StringType
{
    public function getName(): string
    {
        return 'category';
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {

        $cases = 'ENUM(';

        array_filter(CategoryEnum::cases(), function ($case) use (&$cases) {
            return $cases .= '\''.$case->value . '\' , ';
        });

        return substr_replace($cases, '',  -2) . ')';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?CategoryEnum
    {
        return CategoryEnum::from($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof CategoryEnum) {
            return $value->value;
        }

        if (is_string($value)) {
            return CategoryEnum::from($value)->value;
        }
        return null;
    }
}
