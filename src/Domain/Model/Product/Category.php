<?php

declare(strict_types=1);

namespace App\Domain\Model\Product;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Column(type: 'string', enumType: Category::class)]
enum Category: string
{
    case BOOTS = 'boots';
    case SANDALS = 'sandals';
    case SHOES = 'shoes';
    case SNEAKERS = 'sneakers';
}
