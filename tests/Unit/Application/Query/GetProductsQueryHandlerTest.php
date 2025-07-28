<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Query;

use App\Application\Assembler\ProductReadModelAssembler;
use App\Application\Exception\BadRequestException;
use App\Application\Query\GetProductsQuery;
use App\Application\Query\GetProductsQueryHandler;
use App\Application\ReadModel\Paginator;
use App\Application\ReadModel\Product as ReadModelProduct;
use App\Application\ReadModel\ProductCollection;
use App\Domain\Model\Product\Product;
use App\Domain\Model\Product\ProductRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

final class GetProductsQueryHandlerTest extends TestCase
{
    use ProphecyTrait;

    private const INVALID_CATEGORY = 'gloves';
    private ObjectProphecy|ProductReadModelAssembler $productReadModelAssembler;
    private ObjectProphecy|ProductRepository $productRepository;
    private GetProductsQueryHandler $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productRepository = $this->prophesize(ProductRepository::class);
        $this->productReadModelAssembler = $this->prophesize(ProductReadModelAssembler::class);
        $this->sut = new GetProductsQueryHandler(
            $this->productRepository->reveal(),
            $this->productReadModelAssembler->reveal()
        );
    }

    public function testGivenValidRequestThenProductCollectionIsReturned(): void
    {
        $product = $this->prophesize(Product::class);
        $this->productRepository->findPaginatedByFilters(
            [
                'category' => null,
                'priceLessThan' => null,
            ],
            0,
            5
        )->shouldBeCalledOnce()->willReturn([$product->reveal()]);
        $readModelProduct = $this->prophesize(ReadModelProduct::class);
        $readModelProduct = $readModelProduct->reveal();
        $this->productReadModelAssembler->assemble($product)->shouldBeCalledOnce()->willReturn($readModelProduct);
        $query = new GetProductsQuery(null, null, new Paginator(1, 5));
        $data = $this->sut->__invoke($query);

        $this->assertInstanceOf(ProductCollection::class, $data);
        $this->assertCount(1, $data);
        $this->assertSame($readModelProduct, $data->first());
    }

    public function testGivenInvalidRequestThenExceptionIsThrown(): void
    {
        $query = new GetProductsQuery(self::INVALID_CATEGORY, null, new Paginator(1, 5));
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('Invalid category provided');

        $this->sut->__invoke($query);
    }
}
