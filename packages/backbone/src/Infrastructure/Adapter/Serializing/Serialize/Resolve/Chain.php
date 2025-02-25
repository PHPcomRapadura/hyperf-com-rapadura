<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Adapter\Serializing\Serialize\Resolve;

use Backbone\Domain\Support\Value;
use Backbone\Domain\Support\Values;
use Backbone\Infrastructure\Adapter\Serializing\Serialize\Engine;
use ReflectionParameter;

abstract class Chain extends Engine
{
    protected ?Chain $previous = null;

    final public function then(Chain $chain): Chain
    {
        $chain->previous($this);
        return $chain;
    }

    public function resolve(ReflectionParameter $parameter, Values $values): Value
    {
        return isset($this->previous) ? $this->previous->resolve($parameter, $values) : new Value(null);
    }

    protected function previous(Chain $previous): void
    {
        $this->previous = $previous;
    }
}
