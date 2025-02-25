<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Faker\Handler;

use Backbone\Domain\Support\Value;
use ReflectionParameter;
use Throwable;

final class NamedChain extends Chain
{
    public function resolve(ReflectionParameter $parameter): ?Value
    {
        $name = $parameter->getName();
        try {
            return new Value($this->faker->format($name));
        } catch (Throwable) {
        }
        return parent::resolve($parameter);
    }
}
