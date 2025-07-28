<?php

declare(strict_types=1);

namespace App\Application\Exception;

class BadRequestException extends \LogicException
{
    public const KEY_BAD_REQUEST = 'bad_request_exception';
    public const STATUS_CODE = 400;
    public function __construct(
        protected readonly ?string $key = self::KEY_BAD_REQUEST,
        protected $message = 'Bad request exception',
        protected $code = self::STATUS_CODE,
        private readonly ?array $data = null,
        private readonly ?array $meta = null,
        protected ?Throwable $previousException = null
    ) {
        parent::__construct($message, $code, $previousException);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function getMeta(): ?array
    {
        return $this->meta;
    }

    public function getPreviousException(): ?Throwable
    {
        return $this->previousException;
    }
}
