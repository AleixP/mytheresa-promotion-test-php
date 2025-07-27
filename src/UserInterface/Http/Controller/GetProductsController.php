<?php

declare(strict_types=1);

namespace App\UserInterface\Http\Controller;

use App\Application\Query\GetProductsQuery;
use App\Application\Query\GetProductsQueryHandler;
use App\UserInterface\Http\ResponseTransformer\GetProductsTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final readonly class GetProductsController
{
    public function __construct(private GetProductsQueryHandler $getProductsQueryHandler, private GetProductsTransformer $getProductsTransformer){}

    public function __invoke(Request $request): JsonResponse
    {
        $category = $request->query->get('category');
        $priceLessThan =(int)$request->query->get('priceLessThan');
        $page = (int)$request->query->get('page');
        $query = new GetProductsQuery($category, $priceLessThan, $page);

        return new JsonResponse(
            $this->getProductsTransformer->transform(
                $this->getProductsQueryHandler->__invoke($query)
            )
        );
    }
}
