<?php

declare(strict_types=1);

namespace Tests\Support\Faker\Handler;

use App\Domain\Support\Value;
use ReflectionParameter;
use Tests\Support\Faker\FakerHandler;

final class OptionalChain extends FakerHandler
{
    public function resolve(Value $value): ?Value
    {
        $parameter = $value->value;

        assert($parameter instanceof ReflectionParameter);

        if ($parameter->isOptional() || $parameter->isDefaultValueAvailable()) {
            return new Value($parameter->getDefaultValue());
        }
        if ($parameter->allowsNull()) {
            return new Value(null);
        }
        return parent::resolve($value);
    }
}
