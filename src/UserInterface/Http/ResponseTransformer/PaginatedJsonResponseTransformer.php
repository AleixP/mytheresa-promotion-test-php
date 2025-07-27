<?php

declare(strict_types=1);

namespace App\UserInterface\Http\ResponseTransformer;

use App\Application\ReadModel\ProductPaginator;

final class PaginatedJsonResponseTransformer implements PaginatedResponseTransformer
{
    public function transform(ProductPaginator $productPaginator): array
    {
        return [
            'data' => $productPaginator->data(),
            'total' => $productPaginator->total(),
            'page' => $productPaginator->page(),
            'limit' => $productPaginator->limit()
        ];
    }
}
