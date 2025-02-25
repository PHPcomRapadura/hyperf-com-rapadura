<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Adapter\Serializing\Deserialize;

use Backbone\Domain\Support\Value;

abstract class Chain extends Demolisher
{
    protected ?Chain $previous = null;

    final public function then(Chain $chain): Chain
    {
        $chain->previous($this);
        return $chain;
    }

    protected function previous(Chain $previous): void
    {
        $this->previous = $previous;
    }

    public function resolve(mixed $value): Value
    {
        if (! isset($this->previous)) {
            return new Value($value);
        }
        return $this->previous->resolve($value);
    }
}
