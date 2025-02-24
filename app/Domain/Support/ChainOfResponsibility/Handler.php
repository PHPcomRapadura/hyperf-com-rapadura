<?php

declare(strict_types=1);

namespace App\Domain\Support\ChainOfResponsibility;

use App\Domain\Support\Value;

abstract class Handler implements Chain
{
    protected ?Chain $previous = null;

    final public function then(Chain $chain): Chain
    {
        /** @phpstan-ignore property.notFound */
        $chain->previous = $this;
        return $chain;
    }

    public function resolve(Value $value): ?Value
    {
        if (isset($this->previous)) {
            return $this->previous->resolve($value);
        }
        return null;
    }
}
