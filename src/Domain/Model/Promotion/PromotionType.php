<?php

namespace App\Domain\Model\Promotion;

enum PromotionType: string
{
    case SKU = 'sku';
    case CATEGORY = 'category';
}
