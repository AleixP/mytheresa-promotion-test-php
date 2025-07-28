<?php

declare(strict_types=1);

namespace App\UserInterface\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;

interface ExceptionHandler
{
    public function handle(\Throwable $exception): JsonResponse;
}
