<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Adapter\Serializing\Serialize\Prepare;

use Backbone\Domain\Support\Value;
use Backbone\Domain\Support\Values;
use Backbone\Infrastructure\Adapter\Serializing\Serialize\Context;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

use function array_key_exists;
use function Backbone\Type\Cast\toArray;
use function class_exists;
use function is_string;

class DependencyChain extends Chain
{
    /**
     * @throws ReflectionException
     */
    public function resolve(ReflectionParameter $parameter, Values $values): ?Value
    {
        $name = $this->normalize($parameter);
        $class = $this->resolveDependencyClass($parameter);
        if ($class === null) {
            return parent::resolve($parameter, $values);
        }
        $value = $values->get($name);
        $args = $this->resolveDependencyArgs($class, $value);
        if ($args === null) {
            return parent::resolve($parameter, $values);
        }
        $context = new Context($class, $args);
        return new Value($context);
    }

    /**
     * @param ReflectionParameter $parameter
     * @return null|class-string<object>
     */
    private function resolveDependencyClass(ReflectionParameter $parameter): ?string
    {
        $type = $parameter->getType();
        $classes = $this->normalizeType($type);
        foreach ($classes as $class) {
            if (is_string($class) && class_exists($class)) {
                return $class;
            }
        }
        return null;
    }

    /**
     * @template T of object
     * @param class-string<T> $class
     * @param mixed $value
     * @return null|Values
     * @throws ReflectionException
     */
    private function resolveDependencyArgs(string $class, mixed $value): ?Values
    {
        $reflectionClass = new ReflectionClass($class);
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
}
