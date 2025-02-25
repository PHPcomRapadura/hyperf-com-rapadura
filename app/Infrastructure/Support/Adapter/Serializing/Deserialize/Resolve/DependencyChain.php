<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing\Deserialize\Resolve;

use App\Domain\Support\Value;
use App\Infrastructure\Support\Adapter\Serializing\Deserialize\Chain;

class DependencyChain extends Chain
{
    public function resolve(mixed $value): ?Value
    {
        if (is_object($value)) {
            return new Value($this->demolish($value));
        }
        return parent::resolve($value);
    }
}
