<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Support\Adapter\Mapping;

use App\Domain\Exception\MappingException;
use App\Domain\Exception\MappingExceptionItem;
use App\Domain\Support\Values;
use App\Infrastructure\Support\Adapter\Mapping\Mapper;
use App\Infrastructure\Support\CaseConvention;
use DateTime;
use stdClass;
use Tests\TestCase;

class MapperTest extends TestCase
{
    final public function testMapWithValidValues(): void
    {
        $entityClass = MapperTestStubWithConstructor::class;
        $values = [
            'id' => 1,
            'price' => 19.99,
            'name' => 'Test',
            'is_active' => true,
            'tags' => ['tag1', 'tag2'],
            'more' => new MapperTestStubWithNoConstructor(),
        ];

        $mapper = new Mapper();
        $instance = $mapper->map($entityClass, Values::createFrom($values));

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
            'more' => new MapperTestStubWithNoConstructor(),
            'created_at' => '1981-08-13T00:00:00+00:00',
        ];

        $mapper = new Mapper();
        $instance = $mapper->map(MapperTestStubWithConstructor::class, Values::createFrom($values));

        $this->assertInstanceOf(MapperTestStubWithConstructor::class, $instance);
        $this->assertSame(1, $instance->id);
        $this->assertSame(19.99, $instance->price);
        $this->assertSame('Test', $instance->name);
        $this->assertTrue($instance->isActive);
        $this->assertSame([], $instance->tags);
        $this->assertInstanceOf(DateTime::class, $instance->createdAt);
    }

    final public function testMapWithErrors(): void
    {
        $entityClass = MapperTestStubWithConstructor::class;
        $values = [
            'id' => 'invalid',
            'name' => 'Test',
            'is_active' => true,
            'tags' => ['tag1', 'tag2'],
            'more' => new DateTime(),
            'no' => 'invalid',
        ];

        try {
            $mapper = new Mapper();
            $mapper->map($entityClass, Values::createFrom($values));
        } catch (MappingException $e) {
            $errors = $e->getErrors();
            $this->assertContainsOnlyInstancesOf(MappingExceptionItem::class, $errors);
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

        $mapper = new Mapper();
        $instance = $mapper->map(MapperTestStubWithNoConstructor::class, Values::createFrom($values));

        $this->assertInstanceOf(MapperTestStubWithNoConstructor::class, $instance);
    }

    final public function testMapWithReflectionError(): void
    {
        $values = [
            'id' => 1,
            'price' => 19.99,
            'name' => 'Test',
            'is_active' => true,
            'more' => new MapperTestStubWithNoConstructor(),
        ];

        try {
            $mapper = new Mapper();
            $mapper->map('NonExistentClass', Values::createFrom($values));
        } catch (MappingException $e) {
            $errors = $e->getErrors();
            $this->assertContainsOnlyInstancesOf(MappingExceptionItem::class, $errors);
            $this->assertTrue($this->hasErrorMessage($errors, 'Class "NonExistentClass" does not exist'));
        }
    }

    final public function testEdgeTypeCases(): void
    {
        $values = [
            'union' => 1,
            'intersection' => new MapperTestStubEdgeCaseIntersection(),
            'nested' => [
                'id' => 1,
                'price' => 19.99,
                'name' => 'Test',
                'isActive' => true,
                'more' => new MapperTestStubWithNoConstructor(),
                'tags' => ['tag1', 'tag2'],
            ],
            'whatever' => new stdClass(),
        ];

        $mapper = new Mapper(CaseConvention::NONE);
        $instance = $mapper->map(MapperTestStubEdgeCase::class, Values::createFrom($values));

        $this->assertInstanceOf(MapperTestStubEdgeCase::class, $instance);
        $this->assertSame(1, $instance->union);
        $this->assertInstanceOf(MapperTestStubEdgeCaseIntersection::class, $instance->intersection);
        $this->assertInstanceOf(MapperTestStubWithConstructor::class, $instance->nested);
        $this->assertInstanceOf(stdClass::class, $instance->getWhatever());
    }

    private function hasErrorMessage(array $errors, string $message): bool
    {
        foreach ($errors as $error) {
            if ($error->message === $message) {
                return true;
            }
        }
        return false;
    }
}
