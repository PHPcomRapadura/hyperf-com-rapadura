<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Mapping;

use App\Domain\Exception\MappingException;
use App\Domain\Exception\MappingExceptionItem;
use App\Domain\Support\Values;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use Throwable;

class Mapper extends MapperEngine
{
    /**
     * @template T of object
     * @param class-string<T> $class
     * @param Values $values
     *
     * @return T
     * @throws MappingException
     */
    public function map(string $class, Values $values): mixed
    {
        try {
            $reflectionClass = new ReflectionClass($class);
            $constructor = $reflectionClass->getConstructor();

            if ($constructor === null) {
                return new $class();
            }

            $parameters = $constructor->getParameters();
            $values = $this->resolveDependencies($parameters, $values);
            $args = $this->resolveArgs($parameters, $values);
            return $reflectionClass->newInstanceArgs($args);
        } catch (MappingException $e) {
            throw $e;
        } catch (Throwable $e) {
            $errors = [
                new MappingExceptionItem(kind: 'panic', value: $class, message: $e->getMessage()),
            ];
            throw new MappingException($values, $errors);
        }
    }

    /**
     * @param array<ReflectionParameter> $parameters
     * @param Values $values
     * @return Values
     * @throws ReflectionException
     */
    private function resolveDependencies(array $parameters, Values $values): Values
    {
        foreach ($parameters as $parameter) {
            $name = $this->normalize($parameter);
            if (! $values->has($name)) {
                continue;
            }

            $value = $values->get($name);
            $context = $this->resolveDependencyContext($parameter, $value);
            if ($context === null) {
                continue;
            }
            /** @phpstan-ignore argument.type, argument.templateType */
            $values = $values->with($name, $this->map($context->class, $context->values));
        }

        return $values;
    }

    /**
     * @param array<ReflectionParameter> $parameters
     * @param Values $values
     * @return array
     * @throws ReflectionException
     */
    private function resolveArgs(array $parameters, Values $values): array
    {
        $errors = [];
        $args = [];
        foreach ($parameters as $parameter) {
            try {
                $args[] = $this->resolveArgsParameter($parameter, $values);
            } catch (InvalidArgumentException $e) {
                $errors[] = new MappingExceptionItem(
                    $e->getMessage(),
                    $values->get($parameter->getName()),
                    $parameter->getName(),
                );
            }
        }
        if (empty($errors)) {
            return $args;
        }
        throw new MappingException($values, $errors);
    }
}
