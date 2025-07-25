<?php

declare(strict_types=1);

namespace App\Domain\Shared;

abstract class Entity
{
    public function equals(object $other): bool
    {
        return \get_class($this) === \get_class($other) && $this->id()->sameAs($other->id());
    }
}
