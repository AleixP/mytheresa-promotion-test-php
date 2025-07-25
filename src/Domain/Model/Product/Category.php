<?php

namespace App\Domain\Model\Product;

enum Category: string
{
    case BOOTS = 'boots';
    case SANDALS = 'sandals';
    case SHOES = 'shoes';
    case SNEAKERS = 'sneakers';
}
