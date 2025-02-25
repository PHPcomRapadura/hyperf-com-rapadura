<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Collection\Support;

use DomainException;
use stdClass;
use Tests\Support\TestCase;

class CollectionTest extends TestCase
{
    final public function testShouldCreateFromArray(): void
    {
        $data = [['value' => 'foo'], ['value' => 'bar']];
        $serializer = new CollectionTestSerializer();
        $collection = CollectionTestMock::createFrom($data, $serializer);

        $this->assertCount(2, $collection);
    }

    final public function testShouldJsonSerialize(): void
    {
        $data = [['value' => 'foo'], ['value' => 'bar']];
        $serializer = new CollectionTestSerializer();
        $collection = CollectionTestMock::createFrom($data, $serializer);

        $actual = $collection->jsonSerialize();
        $this->assertCount(2, $actual);
    }

    final public function testShouldFailOnInvalidDatum(): void
    {
        $datum = new stdClass();
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage(
            'Invalid type. Expected "Tests\Unit\Domain\Collection\Support\CollectionTestMockStub", got "stdClass"'
        );

        $data = [$datum];
        $serializer = new CollectionTestSerializer();
        CollectionTestMock::createFrom($data, $serializer);
    }
}
