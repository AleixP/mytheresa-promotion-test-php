<?php

declare(strict_types=1);

namespace App\Domain\Shared;

abstract class ValueObject
{
    abstract protected function hasSameValues(object $other): bool;

    public function equals(object $other): bool
    {
        return \get_class($this) === \get_class($other) && $this->hasSameValues($other);
    }
}
