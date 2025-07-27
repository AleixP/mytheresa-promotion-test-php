<?php

declare(strict_types=1);

namespace App\Application\ReadModel;

use Doctrine\Common\Collections\ArrayCollection;

final class ProductCollection extends ArrayCollection
{
    protected const TYPE = Product::class;
}
