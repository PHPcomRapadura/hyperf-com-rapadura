<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Adapter\Serializing\Serialize;

use Serendipity\Infrastructure\Adapter\Serializing\Converter;
use Serendipity\Infrastructure\CaseConvention;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionType;
use ReflectionUnionType;

use function array_map;
use function Serendipity\Type\String\toSnakeCase;
use function is_string;

abstract class Engine
{
    public function __construct(
        public readonly CaseConvention $case = CaseConvention::SNAKE,
        protected readonly array $converters = [],
    ) {
    }

    /**
     * @return array<class-string<object>|string>
     */
    protected function normalizeType(?ReflectionType $type): array
    {
        if ($type instanceof ReflectionNamedType) {
            return [$type->getName()];
        }
        if ($type instanceof ReflectionIntersectionType || $type instanceof ReflectionUnionType) {
            /** @var array<ReflectionNamedType> $reflectionNamedTypes */
            $reflectionNamedTypes = $type->getTypes();
            return array_map(
                fn (ReflectionIntersectionType|ReflectionNamedType $type) => $type->getName(),
                $reflectionNamedTypes
            );
        }
        return [];
    }

    protected function normalize(ReflectionParameter|string $field): string
    {
        $name = is_string($field) ? $field : $field->getName();
        return match ($this->case) {
            CaseConvention::SNAKE => toSnakeCase($name),
            CaseConvention::NONE => $name,
        };
    }

    protected function conversor(string $type): ?Converter
    {
        $converter = $this->converters[$type] ?? null;
        return $converter instanceof Converter ? $converter : null;
    }
}
