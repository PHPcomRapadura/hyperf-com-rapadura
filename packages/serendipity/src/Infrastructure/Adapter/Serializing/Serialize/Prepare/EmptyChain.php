<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Adapter\Serializing\Serialize\Prepare;

use Serendipity\Domain\Support\Value;
use Serendipity\Domain\Support\Values;
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
