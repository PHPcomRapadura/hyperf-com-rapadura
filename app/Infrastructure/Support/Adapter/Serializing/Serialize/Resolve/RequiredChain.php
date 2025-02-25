<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing\Serialize\Resolve;

use App\Domain\Exception\Mapping\NotResolved;
use App\Domain\Exception\Mapping\NotResolvedType;
use App\Domain\Support\Value;
use App\Domain\Support\Values;
use App\Infrastructure\Support\Adapter\Serializing\Serialize\Chain;
use ReflectionException;
use ReflectionParameter;

class RequiredChain extends Chain
{
    /**
     * @throws ReflectionException
     */
    public function resolve(ReflectionParameter $parameter, Values $values): ?Value
    {
        $name = $this->normalize($parameter);
        if ($values->has($name)) {
            return parent::resolve($parameter, $values);
        }
        if ($parameter->isOptional() || $parameter->isDefaultValueAvailable()) {
            return new Value($parameter->getDefaultValue());
        }
        if ($parameter->allowsNull()) {
            return new Value(null);
        }
        return new Value(new NotResolved(NotResolvedType::REQUIRED, $name));
    }
}
