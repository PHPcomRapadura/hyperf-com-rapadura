<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Support\Adapter\Serializing;

use App\Infrastructure\Support\Adapter\Serializing\Serializer;
use Tests\TestCase;

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
