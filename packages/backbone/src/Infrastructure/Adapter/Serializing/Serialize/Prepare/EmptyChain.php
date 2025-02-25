<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Adapter\Serializing\Serialize\Prepare;

use Backbone\Domain\Support\Value;
use Backbone\Domain\Support\Values;
use ReflectionParameter;

class EmptyChain extends Chain
{
    public function resolve(ReflectionParameter $parameter, Values $values): ?Value
    {
        $name = $this->normalize($parameter);
        if (! $values->has($name)) {
            return null;
        }
        return parent::resolve($parameter, $values);
    }
}
