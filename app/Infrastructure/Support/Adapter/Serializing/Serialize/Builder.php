<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing\Serialize;

use App\Domain\Exception\Mapping\NotResolved;
use App\Domain\Exception\MappingException;
use App\Domain\Support\Values;
use App\Infrastructure\Support\Adapter\Serializing\Serialize\Prepare\ConverterChain;
use App\Infrastructure\Support\Adapter\Serializing\Serialize\Prepare\DependencyChain;
use App\Infrastructure\Support\Adapter\Serializing\Serialize\Prepare\EmptyChain;
use App\Infrastructure\Support\Adapter\Serializing\Serialize\Resolve\InvalidChain;
use App\Infrastructure\Support\Adapter\Serializing\Serialize\Resolve\RequiredChain;
use ReflectionClass;
use ReflectionParameter;
use Throwable;

class Builder extends Engine
{
    /**
     * @template T of object
     * @param class-string<T> $class
     * @param Values $values
     *
     * @return T
     * @throws MappingException
     */
    public function build(string $class, Values $values): mixed
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
            $resolved = (new DependencyChain($this->case))
                ->then(new ConverterChain($this->case, $this->converters))
                ->then(new EmptyChain($this->case))
                ->resolve($parameter, $values);

            if ($resolved === null) {
                continue;
            }

            $name = $this->normalize($parameter);
            $value = $resolved->value;
            if ($value instanceof Context) {
                /** @phpstan-ignore argument.type, argument.templateType */
                $value = $this->build($value->class, $value->values);
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
            $resolved = (new InvalidChain($this->case))
                ->then(new RequiredChain($this->case))
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
