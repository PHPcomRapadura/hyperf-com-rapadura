<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Adapter\Serializing\Serialize;

use Serendipity\Domain\Exception\MappingException;
use Serendipity\Domain\Support\Values;
use Serendipity\Infrastructure\Adapter\Serializing\Serialize\Prepare\ConverterChain;
use Serendipity\Infrastructure\Adapter\Serializing\Serialize\Prepare\DependencyChain;
use Serendipity\Infrastructure\Adapter\Serializing\Serialize\Prepare\EmptyChain;
use Serendipity\Infrastructure\Adapter\Serializing\Serialize\Resolve\CheckInvalidChain;
use Serendipity\Infrastructure\Adapter\Serializing\Serialize\Resolve\CheckRequiredChain;
use Serendipity\Infrastructure\Adapter\Serializing\Serialize\Resolve\Consolidator;
use ReflectionClass;
use ReflectionParameter;
use Throwable;

class Builder extends Engine
{
    /**
     * @template T of object
     * @param class-string<T> $class
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
            $value = $resolved->content;
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
     */
    private function resolve(array $parameters, Values $values): array
    {
        $consolidator = new Consolidator();
        foreach ($parameters as $parameter) {
            $resolved = (new CheckInvalidChain($this->case))
                ->then(new CheckRequiredChain($this->case))
                ->resolve($parameter, $values);

            $consolidator->consolidate($resolved);
        }

        if (empty($consolidator->errors())) {
            return $consolidator->args();
        }
        throw new MappingException($values, $consolidator->errors());
    }
}
