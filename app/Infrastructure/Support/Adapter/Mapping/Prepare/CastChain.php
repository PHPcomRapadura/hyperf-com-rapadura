<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Mapping\Prepare;

use App\Domain\Support\Value;
use App\Domain\Support\Values;
use App\Infrastructure\Support\Adapter\Mapping\Chain;
use App\Infrastructure\Support\Adapter\Mapping\Converter;
use ReflectionNamedType;
use ReflectionParameter;

class CastChain extends Chain
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

    private function conversor(string $type): ?Converter
    {
        $converter = $this->converters[$type] ?? null;
        return $converter instanceof Converter ? $converter : null;
    }
}
