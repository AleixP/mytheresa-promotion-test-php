<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Application\Assembler\ProductReadModelAssembler;
use App\Application\ReadModel\ProductCollection;
use App\Domain\Model\Product\Category;
use App\Domain\Model\Product\ProductRepository;

final readonly class GetProductsQueryHandler
{
    public function __construct(
        private ProductRepository $productRepository,
        private ProductReadModelAssembler $productReadModelAssembler,
    ){}

    public function __invoke(GetProductsQuery $query): ProductCollection
    {
        if ($query->category() && !Category::tryFrom($query->category())) {
            throw new \InvalidArgumentException('Invalid category');
        }

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
