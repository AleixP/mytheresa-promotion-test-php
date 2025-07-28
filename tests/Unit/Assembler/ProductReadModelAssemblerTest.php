<?php

declare(strict_types=1);

namespace App\Tests\Unit\Assembler;

use App\Application\Assembler\ProductReadModelAssembler;
use App\Application\Exception\PriceNotFoundExcpetion;
use App\Application\ReadModel\Product as ReadModelProduct;
use App\Domain\Model\Price\Currency;
use App\Domain\Model\Price\Price;
use App\Domain\Model\Price\PriceRepository;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\StockKeepingUnit;
use App\Domain\Model\Promotion\Promotion;
use App\Domain\Service\PromotionEngine;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

class ProductReadModelAssemblerTest extends TestCase
{
    use ProphecyTrait;

    private PriceRepository|ObjectProphecy $priceRepository;
    private ObjectProphecy|PromotionEngine $promotionEngine;
    private ObjectProphecy|Product $product;
    private StockKeepingUnit|ObjectProphecy $sku;

    protected function setUp(): void
    {
        parent::setUp();
        $this->priceRepository = $this->prophesize(PriceRepository::class);
        $this->promotionEngine = $this->prophesize(PromotionEngine::class);
        $this->product = $this->prophesize(Product::class);
        $this->sku = $this->prophesize(StockKeepingUnit::class);
        $this->sku->value()->willReturn('1234');
        $this->product->sku()->willReturn($this->sku->reveal());;

        $this->sut = new ProductReadModelAssembler(
            $this->priceRepository->reveal(),
            $this->promotionEngine->reveal()
        );
    }

    public function testGivenValidProductThenReadModelProductIsReturned(): void
    {
        $price = $this->prophesize(Price::class);
        $promotion = $this->prophesize(Promotion::class);
        $product = $this->product->reveal();
        $this->priceRepository->findBySku($this->sku->reveal(), Currency::from())
            ->shouldBeCalledOnce()->willReturn($price->reveal());
        $this->promotionEngine->resolveBestForProduct($product)
            ->shouldBeCalledOnce()->willReturn($promotion->reveal());

        $data = $this->sut->assemble($product);

        $this->assertInstanceOf(ReadModelProduct::class, $data);
        $this->assertSame($price->reveal(), $data->price());
        $this->assertSame($promotion->reveal(), $data->promotion());
        $this->assertSame($product, $data->product());
    }

    public function testGivenValidProductAndNoPriceIsFoundThenExceptionIsThrown(): void
    {
        $this->priceRepository->findBySku($this->sku->reveal(), Currency::from())
            ->shouldBeCalledOnce()->willReturn(null);
        $this->expectException(PriceNotFoundExcpetion::class);
        $this->expectExceptionMessage('Price not found for product sku: 1234');
        $this->sut->assemble($this->product->reveal());
    }
    public function testGivenValidProductAndWrongCurrencyThenExceptionIsThrown(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Currency USD is not valid');
        $this->sut->assemble($this->product->reveal(), Currency::from('USD'));
    }
}
