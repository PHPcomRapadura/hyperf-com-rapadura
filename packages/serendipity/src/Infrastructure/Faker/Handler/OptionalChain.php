<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Faker\Handler;

use Serendipity\Domain\Support\Value;
use ReflectionParameter;

final class OptionalChain extends Chain
{
    public function resolve(ReflectionParameter $parameter): ?Value
    {
        if ($parameter->isOptional() || $parameter->isDefaultValueAvailable()) {
            return new Value($parameter->getDefaultValue());
        }
        if ($parameter->allowsNull()) {
            return new Value(null);
        }
        return parent::resolve($parameter);
    }
}
