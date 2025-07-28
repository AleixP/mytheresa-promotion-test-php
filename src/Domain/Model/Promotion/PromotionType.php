<?php

declare(strict_types=1);

namespace App\Domain\Model\Promotion;

enum PromotionType: string
{
    case SKU = 'sku';
    case CATEGORY = 'category';
}
