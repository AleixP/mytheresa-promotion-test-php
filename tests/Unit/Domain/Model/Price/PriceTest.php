<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model\Price;

use App\Domain\Model\Price\Price;
use PHPUnit\Framework\TestCase;

final class PriceTest extends TestCase
{
    private const SKU = '001';
    private const PRICE = 100;
    private const DEFAULT_CURRENCY = 'EUR';
    private const WRONG_CURRENCY = 'USD';
    public function testShouldCreateAPriceGivenValidValues(): void
    {
        $sut = Price::createFromPrimitives(
            self::SKU,
            self::PRICE,
            self::DEFAULT_CURRENCY
        );

        $this->assertInstanceOf(Price::class, $sut);
    }

    public function testShouldNotCreateAPricenGivenAWrongCurrency(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Price::createFromPrimitives(
            self::SKU,
            self::PRICE,
            self::WRONG_CURRENCY
        );
    }
}
