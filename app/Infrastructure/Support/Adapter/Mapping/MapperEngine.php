<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Mapping;

use App\Domain\Support\Values;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

use function class_exists;
use function is_string;

abstract class MapperEngine extends MapperEngineCommon
{
    /**
     * @param ReflectionParameter $parameter
     * @param mixed $value
     * @return ?MapperContext
     * @throws ReflectionException
     */
    protected function resolveDependencyContext(ReflectionParameter $parameter, mixed $value): ?MapperContext
    {
        $parameterClass = $this->resolveDependencyContextClass($parameter);
        if ($parameterClass === null) {
            return null;
        }

        $parameterValues = $this->resolveDependencyContextValues($parameterClass, $value);
        if ($parameterValues === null) {
            return null;
        }
        return new MapperContext($parameterClass, $parameterValues);
    }

    /**
     * @param ReflectionParameter $parameter
     * @return null|class-string<object>
     */
    private function resolveDependencyContextClass(ReflectionParameter $parameter): ?string
    {
        $type = $parameter->getType();
        $classes = $this->extractTypes($type);
        foreach ($classes as $class) {
            if (is_string($class) && class_exists($class)) {
                return $class;
            }
        }
        return null;
    }

    /**
     * @template T of object
     * @param class-string<T> $type
     * @param mixed $value
     * @return null|Values
     * @throws ReflectionException
     */
    private function resolveDependencyContextValues(string $type, mixed $value): ?Values
    {
        $reflectionClass = new ReflectionClass($type);
        $constructor = $reflectionClass->getConstructor();
        if ($constructor === null) {
            return null;
        }
        $parameters = $constructor->getParameters();
        if (empty($parameters)) {
            return null;
        }
        return $this->parseParametersToValues($parameters, $value);
    }

    /**
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    protected function resolveArgsParameter(ReflectionParameter $parameter, Values $values): mixed
    {
        $name = $this->normalize($parameter);

        if (! $values->has($name)) {
            return $this->handleArgsMissingParameter($parameter);
        }

        $value = $values->get($name);
        $this->validateArgsParameterType($parameter, $value);

        return $value;
    }

    /**
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    private function handleArgsMissingParameter(ReflectionParameter $parameter): mixed
    {
        if ($parameter->isOptional() || $parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }
        if ($parameter->allowsNull()) {
            return null;
        }

        throw new InvalidArgumentException('required');
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validateArgsParameterType(ReflectionParameter $parameter, mixed $value): void
    {
        $type = $parameter->getType();
        if ($type === null) {
            return;
        }
        $types = $this->extractTypes($type);
        foreach ($types as $type) {
            if ($this->isValidType($value, $type)) {
                return;
            }
        }
        throw new InvalidArgumentException('invalid');
    }
}
