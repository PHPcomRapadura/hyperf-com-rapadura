<?php

declare(strict_types=1);

namespace Serendipity\Test\Unit\Infrastructure\Adapter\Serializing;

use Serendipity\Infrastructure\Adapter\Serializing\Deserializer;
use Serendipity\Infrastructure\Testing\TestCase;
use InvalidArgumentException;

/**
 * @internal
 * @coversNothing
 */
final class DeserializerTest extends TestCase
{
    private Deserializer $deserializer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->deserializer = new Deserializer(Stub::class);
    }

    public function testShouldNotDeserializeInvalidType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $mapped = new class {
        };
        $this->deserializer->deserialize($mapped);
    }

    public function testShouldSerializeToArrayWhenIsNotAnInstanceOfOutputable(): void
    {
        $mapped = new Stub('John Doe', 30);

        $this->assertEquals(['foo' => 'John Doe', 'bar' => 30], $this->deserializer->deserialize($mapped));
    }
}
