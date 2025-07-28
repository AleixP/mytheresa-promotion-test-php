<?php

declare(strict_types=1);

namespace App\UserInterface\Http\Exception;

use App\UserInterface\Exception\ExceptionHandler;
use Symfony\Component\HttpFoundation\JsonResponse;

class HttpExceptionHandler implements ExceptionHandler
{
    const DEFAULT_ERROR_CODE = 400;

    public function handle(\Throwable $exception): JsonResponse
    {
        $key = null;
        $data = null;
        $meta = null;
        try {
            $key = $exception->getKey();
            $data = $exception->getData();
            $meta = $exception->getMeta();
        } catch (\Throwable $e) {
            // nothing to do
        }

        return new JsonResponse([
            'key' => $key,
            'message' => $exception->getMessage(),
            'data' => $data ? [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]: null,
            'meta' => $meta ?: null,
            'trace' => $exception->getTrace(),
            'trace_as_string' => $exception->getTraceAsString(),
            'previous' => $exception->getPrevious() ? $this->handle($exception->getPrevious()) : ''
            ], ($exception->getCode() >=  300 || $exception->getCode() <= 511) ? $exception->getCode(): self::DEFAULT_ERROR_CODE
        );
    }
}
