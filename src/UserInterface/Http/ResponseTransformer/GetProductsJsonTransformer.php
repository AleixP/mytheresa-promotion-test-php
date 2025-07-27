<?php

namespace App\UserInterface\Http\ResponseTransformer;

use App\Application\ReadModel\Product as ReadModelProduct;
use App\Application\ReadModel\ProductCollection;

class GetProductsJsonTransformer implements GetProductsTransformer
{

    public function transform(ProductCollection $productCollection): array
    {

        $products = [];
        /** @var ReadModelProduct $product */
        foreach ($productCollection as $product) {
            $products[] = [
                'sku' => $product->product()->sku()->value(),
                'name' => $product->product()->name(),
                'category' => $product->product()->category()->value,
                'price' => $this->getPriceFormatted($product)
            ];
        }
        return $products;
    }

    private function getPriceFormatted(ReadModelProduct $product): array
    {
        $promotionDiscountPercentage = $product->promotion()?->percentage();
        return [
            'original' => $product->price()->price(),
            'final' => round($promotionDiscountPercentage ? $product->price()->price() * ((100 - $promotionDiscountPercentage) / 100) : $product->price()->price()),
            'discount_percentage' => $promotionDiscountPercentage ? $promotionDiscountPercentage.'%' : null,
            'currency' => $product->price()->currency()->value()
        ];
    }
}
