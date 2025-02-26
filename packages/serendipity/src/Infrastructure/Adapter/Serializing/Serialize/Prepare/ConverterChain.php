<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Adapter\Serializing\Serialize\Prepare;

use Serendipity\Domain\Support\Value;
use Serendipity\Domain\Support\Values;
use ReflectionNamedType;
use ReflectionParameter;

class ConverterChain extends Chain
{
    public function resolve(ReflectionParameter $parameter, Values $values): ?Value
    {
        $type = $parameter->getType();
        if (! $type instanceof ReflectionNamedType) {
            return parent::resolve($parameter, $values);
        }
        $conversor = $this->conversor($type->getName());
        if ($conversor === null) {
            return parent::resolve($parameter, $values);
        }
        $value = $conversor->convert($values->get($this->normalize($parameter)));
        return new Value($value);
    }
}
