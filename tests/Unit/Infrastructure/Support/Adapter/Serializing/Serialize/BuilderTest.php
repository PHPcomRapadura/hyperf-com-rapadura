<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Support\Adapter\Serializing\Serialize;

use App\Domain\Exception\Mapping\NotResolved;
use App\Domain\Exception\MappingException;
use App\Domain\Support\Values;
use App\Infrastructure\Repository\Relational\Converter\FromDatabaseToArray;
use App\Infrastructure\Support\Adapter\Serializing\Serialize\Builder;
use App\Infrastructure\Support\CaseConvention;
use DateTime;
use stdClass;
use Tests\TestCase;

use function Util\Type\Json\encode;

class BuilderTest extends TestCase
{
    final public function testMapWithValidValues(): void
    {
        $entityClass = BuilderTestStubWithConstructor::class;
        $values = [
            'id' => 1,
            'price' => 19.99,
            'name' => 'Test',
            'is_active' => true,
            'tags' => encode(['tag1', 'tag2']),
            'more' => new BuilderTestStubWithNoConstructor(),
        ];

        $mapper = new Builder(converters: [
            'array' => new FromDatabaseToArray(),
        ]);
        $instance = $mapper->build($entityClass, Values::createFrom($values));

        $this->assertInstanceOf($entityClass, $instance);
        $this->assertSame(1, $instance->id);
        $this->assertSame(19.99, $instance->price);
        $this->assertSame('Test', $instance->name);
        $this->assertTrue($instance->isActive);
        $this->assertSame(['tag1', 'tag2'], $instance->tags);
        $this->assertNull($instance->createdAt);
    }

    final public function testMapWithMissingOptionalValue(): void
    {
        $values = [
            'id' => 1,
            'price' => 19.99,
            'name' => 'Test',
            'is_active' => true,
            'more' => new BuilderTestStubWithNoConstructor(),
            'created_at' => '1981-08-13T00:00:00+00:00',
        ];

        $mapper = new Builder();
        $instance = $mapper->build(BuilderTestStubWithConstructor::class, Values::createFrom($values));

        $this->assertInstanceOf(BuilderTestStubWithConstructor::class, $instance);
        $this->assertSame(1, $instance->id);
        $this->assertSame(19.99, $instance->price);
        $this->assertSame('Test', $instance->name);
        $this->assertTrue($instance->isActive);
        $this->assertSame([], $instance->tags);
        $this->assertInstanceOf(DateTime::class, $instance->createdAt);
    }

    final public function testMapWithErrors(): void
    {
        $entityClass = BuilderTestStubWithConstructor::class;
        $values = [
            'id' => 'invalid',
            'name' => 'Test',
            'is_active' => true,
            'tags' => ['tag1', 'tag2'],
            'more' => new DateTime(),
            'no' => 'invalid',
        ];

        try {
            $mapper = new Builder();
            $mapper->build($entityClass, Values::createFrom($values));
        } catch (MappingException $e) {
            $errors = $e->getUnresolved();
            $this->assertContainsOnlyInstancesOf(NotResolved::class, $errors);
            $messages = [
                "The value for 'id' is not of the expected type.",
                "The value for 'price' is required and was not provided.",
                "The value for 'more' is not of the expected type.",
            ];
            foreach ($messages as $message) {
                if ($this->hasErrorMessage($errors, $message)) {
                    continue;
                }
                $this->fail(sprintf('Error message "%s" not found', $message));
            }
        }
    }

    final public function testMapWithNoConstructor(): void
    {
        $values = [];

        $mapper = new Builder();
        $instance = $mapper->build(BuilderTestStubWithNoConstructor::class, Values::createFrom($values));

        $this->assertInstanceOf(BuilderTestStubWithNoConstructor::class, $instance);
    }

    final public function testMapWithReflectionError(): void
    {
        $this->expectException(MappingException::class);
        $this->expectExceptionMessage('Class "NonExistentClass" does not exist');

        $values = [
            'id' => 1,
            'price' => 19.99,
            'name' => 'Test',
            'is_active' => true,
            'more' => new BuilderTestStubWithNoConstructor(),
        ];

        $mapper = new Builder();
        $mapper->build('NonExistentClass', Values::createFrom($values));
    }

    final public function testMapWithReflectionInvalidArgsError(): void
    {
        $this->expectException(MappingException::class);

        $values = [];

        $mapper = new Builder();
        $mapper->build(BuilderTestStubWithConstructor::class, Values::createFrom($values));
    }

    final public function testEdgeTypeCases(): void
    {
        $values = [
            'union' => 1,
            'intersection' => new BuilderTestStubEdgeCaseIntersection(),
            'nested' => [
                'id' => 1,
                'price' => 19.99,
                'name' => 'Test',
                'isActive' => true,
                'more' => new BuilderTestStubWithNoConstructor(),
                'tags' => ['tag1', 'tag2'],
            ],
            'whatever' => new stdClass(),
        ];

        $mapper = new Builder(CaseConvention::NONE);
        $instance = $mapper->build(BuilderTestStubEdgeCase::class, Values::createFrom($values));

        $this->assertInstanceOf(BuilderTestStubEdgeCase::class, $instance);
        $this->assertSame(1, $instance->union);
        $this->assertInstanceOf(BuilderTestStubEdgeCaseIntersection::class, $instance->intersection);
        $this->assertInstanceOf(BuilderTestStubWithConstructor::class, $instance->nested);
        $this->assertInstanceOf(stdClass::class, $instance->getWhatever());
    }

    private function hasErrorMessage(array $errors, string $message): bool
    {
        foreach ($errors as $error) {
            if ($error->message() === $message) {
                return true;
            }
        }
        return false;
    }
}
