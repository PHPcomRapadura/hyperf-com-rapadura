<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Mapping;

use App\Domain\Support\Values;
use App\Infrastructure\Support\CaseConvention;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionType;
use ReflectionUnionType;

use function array_key_exists;
use function array_map;
use function gettype;
use function Util\Type\Cast\toArray;
use function Util\Type\String\toSnakeCase;

abstract class MapperEngineCommon
{
    public function __construct(public readonly CaseConvention $case = CaseConvention::SNAKE)
    {
    }

    /**
     * @param array<ReflectionParameter> $parameters
     * @param mixed $value
     * @return Values
     */
    protected function parseParametersToValues(array $parameters, mixed $value): Values
    {
        $input = toArray($value, [$value]);
        $values = [];
        foreach ($parameters as $index => $parameter) {
            $name = $this->normalize($parameter);
            if (array_key_exists($name, $input) || array_key_exists($index, $input)) {
                $values[$name] = $input[$name] ?? $input[$index];
            }
        }
        return Values::createFrom($values);
    }

    protected function isValidType(mixed $value, string $expected): bool
    {
        $type = gettype($value);
        $actual = match ($type) {
            'double' => 'float',
            'integer' => 'int',
            'boolean' => 'bool',
            default => $type,
        };

        return $actual === $expected || ($type === 'object' && $value instanceof $expected);
    }

    /**
     * @param ?ReflectionType $type
     * @return array<class-string<object>|string>
     */
    protected function extractTypes(?ReflectionType $type): array
    {
        if ($type instanceof ReflectionNamedType) {
            return [$type->getName()];
        }
        if ($type instanceof ReflectionIntersectionType || $type instanceof ReflectionUnionType) {
            /** @var array<ReflectionNamedType> $reflectionNamedTypes */
            $reflectionNamedTypes = $type->getTypes();
            return array_map(
                fn (ReflectionNamedType|ReflectionIntersectionType $type) => $type->getName(),
                $reflectionNamedTypes
            );
        }
        return [];
    }

    protected function normalize(ReflectionParameter $parameter): string
    {
        $name = $parameter->getName();
        return match ($this->case) {
            CaseConvention::SNAKE => toSnakeCase($name),
            CaseConvention::NONE => $name,
        };
    }
}
