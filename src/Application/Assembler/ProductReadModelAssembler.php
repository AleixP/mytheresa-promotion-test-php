<?php

declare(strict_types=1);

namespace App\Application\Assembler;

use App\Application\ReadModel\Product as ReadModelProduct;
use App\Domain\Model\Price\Currency;
use App\Domain\Model\Price\PriceRepository;
use App\Domain\Service\PromotionEngine;
use App\Domain\Model\Product\Product;

final class ProductReadModelAssembler
{

    public function __construct(
        private PriceRepository $priceRepository,
        private PromotionEngine $promotionEngine
    ) {}

    public function assemble(Product $product, ?Currency $currency = null): ReadModelProduct
    {
        $price = $this->priceRepository->findBySku($product->sku(), Currency::from($currency));
        $promotion = $this->promotionEngine->resolveBestForProduct($product);

        return new ReadModelProduct(
            $product,
            $price,
            $promotion
        );
    }
}
