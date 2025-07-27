<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Service;

use App\Domain\Model\Product\Category;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\StockKeepingUnit;
use App\Domain\Model\Promotion\Promotion;
use App\Domain\Model\Promotion\PromotionRepository;
use App\Domain\Service\PromotionEngine;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

final class PromotionEngineTest extends TestCase
{
    use ProphecyTrait;

    private ObjectProphecy|PromotionRepository $promotionRepository;
    private ObjectProphecy|Product $product;
    private StockKeepingUnit $sku;
    private Category $category;

    public function setUp(): void
    {
        parent::setUp();
        $this->promotionRepository = $this->prophesize(PromotionRepository::class);
        $this->product = $this->prophesize(Product::class);
        $this->sku = StockKeepingUnit::from('1234');
        $this->category = Category::from('boots');

        $this->product->sku()->willReturn($this->sku);
        $this->product->category()->willReturn($this->category);

        $this->sut = new PromotionEngine($this->promotionRepository->reveal());
    }
    public function testGivenAProductThenAPromotionIsFound(): void
    {
        $promotion = $this->prophesize(Promotion::class);
        $promotion->percentage()->willReturn(10);
        $this->promotionRepository->findByFilters([
            'applicableTo' => [
                $this->sku->value(),
                $this->category->value]
        ])->shouldBeCalledOnce()->willReturn([$promotion->reveal()]);

        $data = $this->sut->resolveBestForProduct($this->product->reveal());
        $this->assertInstanceOf(Promotion::class, $data);
        $this->assertEquals(10, $data->percentage());
    }
    public function testGivenAProductThenNoPromotionIsFound(): void
    {

        $this->promotionRepository->findByFilters([
            'applicableTo' => [
                $this->sku->value(),
                $this->category->value]
        ])->shouldBeCalledOnce()->willReturn([]);

        $data = $this->sut->resolveBestForProduct($this->product->reveal());
        $this->assertNull($data);
    }
    public function testGivenAProductThenMultiplePromotionsAreFound(): void
    {
        $promotion1 = $this->prophesize(Promotion::class);
        $promotion1->percentage()->willReturn(10);
        $promotion2 = $this->prophesize(Promotion::class);
        $promotion2->percentage()->willReturn(25);
        $this->promotionRepository->findByFilters([
            'applicableTo' => [
                $this->sku->value(),
                $this->category->value]
        ])->shouldBeCalledOnce()->willReturn([$promotion1->reveal(), $promotion2->reveal()]);

        $data = $this->sut->resolveBestForProduct($this->product->reveal());
        $this->assertInstanceOf(Promotion::class, $data);
        $this->assertEquals(25, $data->percentage());
    }
}
