<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Faker\Handler;

use Backbone\Domain\Support\Value;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;
use RuntimeException;
use Throwable;

final class TypedChain extends Chain
{
    public function resolve(ReflectionParameter $parameter): ?Value
    {
        $type = $this->extractType($parameter);
        if ($type === null) {
            return new Value(null);
        }
        try {
            $generated = $this->faker->format($type);
            return new Value($generated);
        } catch (Throwable) {
        }
        return parent::resolve($parameter);
    }

    public function extractType(ReflectionParameter $parameter): ?string
    {
        $type = $parameter->getType();
        if ($type instanceof ReflectionUnionType) {
            /** @var array<ReflectionNamedType> $reflectionNamedTypes */
            $reflectionNamedTypes = $type->getTypes();
            return $reflectionNamedTypes[0]->getName();
        }
        if ($type instanceof ReflectionNamedType) {
            return $type->getName();
        }
        if ($type instanceof ReflectionIntersectionType) {
            throw new RuntimeException(
                sprintf(
                    'Intersection type not supported for parameter "%s". Please provide a preset value for it',
                    $parameter->getName()
                )
            );
        }
        return null;
    }
}
