<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model\Product;

use App\Domain\Model\Product\StockKeepingUnit;
use PHPUnit\Framework\TestCase;

final class StockKeepingUnitTest extends TestCase
{
    private const SKU = '001';

    public function testShouldCreateASkuGivenValidValues(): void
    {
        $sut = StockKeepingUnit::from(self::SKU);

        $this->assertInstanceOf(StockKeepingUnit::class, $sut);
    }

}
