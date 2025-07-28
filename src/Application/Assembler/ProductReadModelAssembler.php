<?php

declare(strict_types=1);

namespace App\Application\Assembler;

use App\Application\Exception\PriceNotFoundExcpetion;
use App\Application\ReadModel\Product as ReadModelProduct;
use App\Domain\Model\Price\Currency;
use App\Domain\Model\Price\PriceRepository;
use App\Domain\Service\PromotionEngine;
use App\Domain\Model\Product\Product;

class ProductReadModelAssembler
{

    public function __construct(
        private readonly PriceRepository $priceRepository,
        private readonly PromotionEngine $promotionEngine
    ) {}

    public function assemble(Product $product, ?Currency $currency = null): ReadModelProduct
    {
        $price = $this->priceRepository->findBySku($product->sku(), Currency::from($currency));

        if (!$price) {
            throw new PriceNotFoundExcpetion(
                'price.not_found',
                'Price not found for product sku: '. $product->sku()->value(),
                PriceNotFoundExcpetion::STATUS_CODE,
                ['sku' => $product->sku()->value()]
            );
        }
        $promotion = $this->promotionEngine->resolveBestForProduct($product);

        return new ReadModelProduct(
            $product,
            $price,
            $promotion
        );
    }
}
