<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model\Product;

use App\Domain\Model\Product\Product;
use PHPUnit\Framework\TestCase;
use ValueError;

final class ProductTest extends TestCase
{
    private const NAME = 'Nike Metcon 8, Mat Fraser version';
    private const SKU = '001';
    private const CATEGORY = 'shoes';
    private const INVALID_CATEGORY = 'gloves';

    public function testShouldCreateAProductGivenValidValues(): void
    {
        $sut = Product::createFromPrimitives(
            self::NAME,
            self::SKU,
            self::CATEGORY
        );

        $this->assertInstanceOf(Product::class, $sut);
    }

    public function testShouldNotCreateAProductGivenAWrongCategory(): void
    {
        $this->expectException(ValueError::class);

        Product::createFromPrimitives(
            self::NAME,
            self::SKU,
            self::INVALID_CATEGORY
        );
    }
}
