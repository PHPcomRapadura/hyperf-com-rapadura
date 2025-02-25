<?php

declare(strict_types=1);

namespace BackboneTest\Unit\Domain\Collection\Support;

use Backbone\Infrastructure\Testing\TestCase;
use DomainException;
use stdClass;

/**
 * @internal
 * @coversNothing
 */
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
        $actual = CollectionTestMock::createFrom($data, $serializer)->jsonSerialize();
        $this->assertCount(2, $actual);
    }

    final public function testShouldFailOnInvalidDatum(): void
    {
        $datum = new stdClass();
        $this->expectException(DomainException::class);

        $data = [$datum];
        $serializer = new CollectionTestSerializer();
        CollectionTestMock::createFrom($data, $serializer);
    }
}
