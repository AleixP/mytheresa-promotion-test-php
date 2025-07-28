<?php

declare(strict_types=1);

namespace App\UserInterface\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final readonly class GetHealthzController
{
    public function __construct(){}
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(['status' => 'ok'], 200);
    }
}
