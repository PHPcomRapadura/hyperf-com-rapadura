<?php

declare(strict_types=1);

namespace BackboneTest\Unit\Infrastructure\Adapter\Serializing;

use Backbone\Infrastructure\Adapter\Serializing\Serializer;
use Backbone\Infrastructure\Testing\TestCase;

/**
 * @internal
 * @coversNothing
 */
class SerializerTest extends TestCase
{
    private Serializer $serializer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serializer = new Serializer(Stub::class);
    }

    public function testSerialize(): void
    {
        $datum = ['foo' => 'John Doe', 'bar' => 30];

        $result = $this->serializer->serialize($datum);

        $this->assertEquals('John Doe', $result->foo);
        $this->assertEquals(30, $result->bar);
    }
}
