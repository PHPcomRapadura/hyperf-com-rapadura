<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Adapter\Serializing\Deserialize\Resolve;

use Backbone\Domain\Support\Value;
use Backbone\Infrastructure\Adapter\Serializing\Deserialize\Chain;

class DependencyChain extends Chain
{
    public function resolve(mixed $value): Value
    {
        if (is_object($value)) {
            return new Value($this->demolish($value));
        }
        return parent::resolve($value);
    }
}
