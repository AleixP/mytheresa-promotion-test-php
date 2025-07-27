<?php

declare(strict_types=1);

namespace App\Domain\Model\Promotion;

use Doctrine\ORM\Mapping as ORM;
#[ORM\Column(type: 'string', enumType: PromotionType::class)]
enum PromotionType: string
{
    case SKU = 'sku';
    case CATEGORY = 'category';
}
