<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Model\Promotion;

use App\Domain\Model\Promotion\Promotion;
use PHPUnit\Framework\TestCase;
use ValueError;

final class PromotionTest extends TestCase
{
    private const PROMOTION_TYPE = 'category';
    private const INVALID_PROMOTION_TYPE = 'category2';
    private const APPLICABLE_TO = 'boots';
    private const PERCENTAGE = 30;
    public function testShouldCreateAPromotionGivenValidValues(): void
    {
        $sut = Promotion::createFromPrimitives(
            self::PROMOTION_TYPE,
            self::APPLICABLE_TO,
            self::PERCENTAGE
        );

        $this->assertInstanceOf(Promotion::class, $sut);
    }

    public function testShouldNotCreateAPromotionGivenAWrongPromotionType(): void
    {
        $this->expectException(ValueError::class);

        Promotion::createFromPrimitives(
            self::INVALID_PROMOTION_TYPE,
            self::APPLICABLE_TO,
            self::PERCENTAGE
        );
    }
}
