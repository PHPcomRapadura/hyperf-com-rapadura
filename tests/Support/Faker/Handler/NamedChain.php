<?php

declare(strict_types=1);

namespace Tests\Support\Faker\Handler;

use App\Domain\Support\Value;
use ReflectionParameter;
use Tests\Support\Faker\FakerHandler;
use Throwable;

final class NamedChain extends FakerHandler
{
    public function resolve(Value $value): ?Value
    {
        $parameter = $value->value;

        assert($parameter instanceof ReflectionParameter);

        $name = $parameter->getName();
        try {
            $generated = $this->faker->format($name);
            return new Value($generated);
        } catch (Throwable) {
        }
        return parent::resolve($value);
    }
}
