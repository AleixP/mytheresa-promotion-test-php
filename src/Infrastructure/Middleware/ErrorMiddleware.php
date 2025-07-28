<?php

declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use App\UserInterface\Exception\ExceptionHandler;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final readonly class ErrorMiddleware
{
    public function __construct(private ExceptionHandler $exceptionHandler){}

    public function __invoke(ExceptionEvent $event): void
    {
        $event->setResponse($this->exceptionHandler->handle($event->getThrowable()));
    }
}
