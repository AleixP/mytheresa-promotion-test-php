<?php

declare(strict_types=1);

namespace App\Domain\Model\Product;
enum Category: string
{
    case BOOTS = 'boots';
    case SANDALS = 'sandals';
    case SHOES = 'shoes';
    case SNEAKERS = 'sneakers';
}
