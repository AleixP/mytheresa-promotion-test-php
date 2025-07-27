<?php

declare(strict_types=1);

namespace App\UserInterface\Http\ResponseTransformer;

use App\Application\ReadModel\ProductCollection;

interface GetProductsTransformer
{
    public function transform(ProductCollection $productCollection): array;
}
