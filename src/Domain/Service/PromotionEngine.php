<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Model\Product\Product;
use App\Domain\Model\Promotion\Promotion;
use App\Domain\Model\Promotion\PromotionRepository;

class PromotionEngine
{
    public function __construct(private readonly PromotionRepository $promotionRepository){}

    public function resolveBestForProduct(Product $product): ?Promotion
    {
        $availablePromotions = $this->promotionRepository->findByFilters([
            'applicableTo' => [
                $product->sku()->value(),
                $product->category()->value
            ]
           ]
        );
        return $this->findBestPromotion($availablePromotions);
    }


    public function findBestPromotion(array $availablePromotions): ?Promotion
    {
        /** @var Promotion $bestPromotion */
        $bestPromotion = null;
        foreach ($availablePromotions as $availablePromotion) {
            if (!$bestPromotion || $bestPromotion->percentage() < $availablePromotion->percentage()) {
                $bestPromotion = $availablePromotion;
            }
        }
        return $bestPromotion;
    }
}
