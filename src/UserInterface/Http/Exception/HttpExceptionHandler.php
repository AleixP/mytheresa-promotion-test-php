<?php

declare(strict_types=1);

namespace App\UserInterface\Http\Exception;

use App\UserInterface\Exception\ExceptionHandler;
use Symfony\Component\HttpFoundation\JsonResponse;

class HttpExceptionHandler implements ExceptionHandler
{
    public function handle(\Throwable $exception): JsonResponse
    {
        return new JsonResponse([
            'key' => $exception->getKey() ?? null,
            'message' => $exception->getMessage(),
            'data' => $exception->getData() ?? [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ],
            'meta' => $exception->getMeta() ?? null,
            'trace' => $exception->getTrace(),
            'trace_as_string' => $exception->getTraceAsString(),
            'previous' => $exception->getPrevious() ? $this->handle($exception->getPrevious()) : ''
        ], $exception->getCode());
    }
}
