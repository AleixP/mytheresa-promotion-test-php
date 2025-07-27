<?php

declare(strict_types=1);

namespace App\UserInterface\Http\ResponseTransformer;

use App\Application\ReadModel\ProductPaginator;

interface PaginatedResponseTransformer
{
    public function transform(ProductPaginator $productPaginator): array;
}
