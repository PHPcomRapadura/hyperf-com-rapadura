<?php

declare(strict_types=1);

namespace Tests\Support\Faker;

use App\Domain\Support\Value;
use App\Domain\Support\Values;
use App\Infrastructure\Support\CaseConvention;
use App\Infrastructure\Support\Persistence\Generator;
use Faker\Factory;
use Faker\Generator as FakerMachine;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use Tests\Support\Faker\Handler\NamedChain;
use Tests\Support\Faker\Handler\OptionalChain;
use Tests\Support\Faker\Handler\TypedChain;

use function Util\Type\String\toSnakeCase;

readonly class Faker
{
    public FakerMachine $faker;

    public function __construct(
        public Generator $generator,
        private CaseConvention $case = CaseConvention::SNAKE,
    ) {
        $this->faker = Factory::create('pt_BR');
        $this->faker->addProvider(
            new class ($generator) {
                public function __construct(private readonly Generator $generator)
                {
                }

                public function id(): string
                {
                    return $this->generator->id();
                }

                public function updatedAt(): string
                {
                    return $this->generator->now();
                }

                public function createdAt(): string
                {
                    return $this->generator->now();
                }
            }
        );
    }

    public function fake(string $class, array $presets = []): Values
    {
        $preset = new Values($presets);
        $reflectionClass = new ReflectionClass($class);
        $constructor = $reflectionClass->getConstructor();
        if ($constructor === null) {
            return new $class();
        }

        return $this->parseValues($constructor, $preset);
    }

    public function parseValues(ReflectionMethod $constructor, Values $preset): Values
    {
        $values = [];
        $parameters = $constructor->getParameters();
        foreach ($parameters as $parameter) {
            $field = $this->normalize($parameter);
            if ($preset->has($field)) {
                $values[$field] = $preset->get($field);
                continue;
            }
            $generated = $this->generateValue($parameter);
            if ($generated === null) {
                continue;
            }
            $values[$field] = $generated->value;
        }
        return Values::createFrom($values);
    }

    private function generateValue(ReflectionParameter $parameter): ?Value
    {
        return (new TypedChain($this->faker))
            ->then(new NamedChain($this->faker))
            ->then(new OptionalChain($this->faker))
            ->resolve(new Value($parameter));
    }

    private function normalize(ReflectionParameter $parameter): string
    {
        $name = $parameter->getName();
        return match ($this->case) {
            CaseConvention::SNAKE => toSnakeCase($name),
            CaseConvention::NONE => $name,
        };
    }
}
