<?php

namespace App\Application\Exception;


use Throwable;

final class PriceNotFoundExcpetion extends \LogicException
{
    public const KEY_NOT_FOUND = 'price.not_found';
    public const STATUS_CODE = 404;

    public function __construct(
        protected $message = 'price not found',
        private readonly ?array $data = null,
        protected readonly ?string $key = self::KEY_NOT_FOUND,
        protected $code = self::STATUS_CODE,
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
