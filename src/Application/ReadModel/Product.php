<?php

declare(strict_types=1);

namespace App\Application\ReadModel;

use App\Domain\Model\Product\Product as DomainProduct;
use App\Domain\Model\Promotion\Promotion as DomainPromotion;
use App\Domain\Model\Price\Price as DomainPrice;

class Product
{
    public function __construct(
        public readonly DomainProduct $product,
        public readonly DomainPrice $price,
        public readonly ?DomainPromotion $promotion
    ) {}

    public function product(): DomainProduct
    {
        return $this->product;
    }
    public function price(): DomainPrice
    {
        return $this->price;
    }
    public function promotion(): ?DomainPromotion
    {
        return $this->promotion;
    }
}
