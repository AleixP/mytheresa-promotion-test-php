<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Application\Assembler\ProductReadModelAssembler;
use App\Application\ReadModel\ProductCollection;
use App\Domain\Model\Product\ProductRepository;

final class GetProductsQueryHandler
{
    public function __construct(
        private ProductRepository $productRepository,
        private ProductReadModelAssembler $productReadModelAssembler,
    ){}

    public function __invoke(GetProductsQuery $query): ProductCollection
    {
        $products = $this->productRepository->findPaginatedByFilters(
            [
                'category' => $query->category(),
                'priceLessThan' => $query->priceLessThan()
            ],
            $query->paginator()->page() - 1,
            $query->paginator()->limit()
        );

        $productCollection = new ProductCollection();
        foreach ($products as $product) {
            $productCollection->add($this->productReadModelAssembler->assemble($product));
        }

        return $productCollection;
    }
}
