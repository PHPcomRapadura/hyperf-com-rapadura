<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing\Serialize\Prepare;

use App\Domain\Support\Value;
use App\Domain\Support\Values;
use App\Infrastructure\Support\Adapter\Serializing\Serialize\Chain;
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
