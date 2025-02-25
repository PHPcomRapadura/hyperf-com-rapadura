<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Mapping;

use App\Domain\Exception\Mapping\NotResolved;
use App\Domain\Exception\MappingException;
use App\Domain\Support\Values;
use App\Infrastructure\Support\Adapter\Mapping\Prepare\CastChain;
use App\Infrastructure\Support\Adapter\Mapping\Prepare\DependencyChain;
use App\Infrastructure\Support\Adapter\Mapping\Prepare\EmptyChain;
use App\Infrastructure\Support\Adapter\Mapping\Resolve\InvalidChain;
use App\Infrastructure\Support\Adapter\Mapping\Resolve\RequiredChain;
use ReflectionClass;
use ReflectionParameter;
use Throwable;

class Mapper extends Engine
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
            $values = $this->prepare($parameters, $values);
            $args = $this->resolve($parameters, $values);
            return $reflectionClass->newInstanceArgs($args);
        } catch (MappingException $e) {
            throw $e;
        } catch (Throwable $error) {
            throw new MappingException(values: $values, error: $error);
        }
    }

    /**
     * @param array<ReflectionParameter> $parameters
     * @param Values $values
     * @return Values
     */
    private function prepare(array $parameters, Values $values): Values
    {
        foreach ($parameters as $parameter) {
            $resolved = (new DependencyChain($this->case, $this->converters))
                ->then(new CastChain($this->case, $this->converters))
                ->then(new EmptyChain($this->case, $this->converters))
                ->resolve($parameter, $values);

            if ($resolved === null) {
                continue;
            }

            $name = $this->normalize($parameter);
            $value = $resolved->value;
            if ($value instanceof Context) {
                /** @phpstan-ignore argument.type, argument.templateType */
                $value = $this->map($value->class, $value->values);
            }
            $values = $values->with($name, $value);
        }

        return $values;
    }

    /**
     * @param array<ReflectionParameter> $parameters
     * @param Values $values
     * @return array
     */
    private function resolve(array $parameters, Values $values): array
    {
        $errors = [];
        $args = [];
        foreach ($parameters as $parameter) {
            $resolved = (new InvalidChain($this->case, $this->converters))
                ->then(new RequiredChain($this->case, $this->converters))
                ->resolve($parameter, $values);
            if ($resolved === null) {
                continue;
            }

            if ($resolved->value instanceof NotResolved) {
                $errors[] = $resolved->value;
                continue;
            }
            $args[] = $resolved->value;
        }

        if (empty($errors)) {
            return $args;
        }
        throw new MappingException($values, $errors);
    }
}
