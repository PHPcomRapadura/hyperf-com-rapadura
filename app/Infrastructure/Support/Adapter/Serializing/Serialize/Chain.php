<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing\Serialize;

use App\Domain\Support\Value;
use App\Domain\Support\Values;
use ReflectionParameter;

abstract class Chain extends Engine
{
    protected ?Chain $previous = null;

    final public function then(Chain $chain): Chain
    {
        $chain->previous($this);
        return $chain;
    }

    public function resolve(ReflectionParameter $parameter, Values $values): ?Value
    {
        if (isset($this->previous)) {
            return $this->previous->resolve($parameter, $values);
        }
        return null;
    }

    protected function previous(Chain $previous): void
    {
        $this->previous = $previous;
    }
}
