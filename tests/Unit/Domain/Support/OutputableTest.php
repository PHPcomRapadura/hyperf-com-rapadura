<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Support;

use App\Domain\Support\Outputable;
use Tests\TestCase;

class OutputableTest extends TestCase
{
    public function testJsonSerializeReturnsObjectVars(): void
    {
        $entity = new class extends Outputable {
            public string $property1 = 'value1';

            public int $property2 = 123;
        };

        $expected = [
            'property1' => 'value1',
            'property2' => 123,
        ];

        $this->assertEquals($expected, $entity->jsonSerialize());
    }

    public function testJsonSerializeWithEmptyOutputable(): void
    {
        $entity = new class extends Outputable {
        };

        $this->assertEquals([], $entity->jsonSerialize());
    }

    public function testJsonSerializeWithNullProperties(): void
    {
        $entity = new class extends Outputable {
            public ?string $property1 = null;

            public ?int $property2 = null;
        };

        $expected = [
            'property1' => null,
            'property2' => null,
        ];

        $this->assertEquals($expected, $entity->jsonSerialize());
    }

    public function testToStringReturnsJsonString(): void
    {
        $entity = new class extends Outputable {
            public string $property1 = 'value1';

            public int $property2 = 123;
        };

        $expected = '{"property1":"value1","property2":123}';

        $this->assertEquals($expected, (string) $entity);
    }

    public function testToStringHandlesJsonException(): void
    {
        $entity = new class extends Outputable {
            public mixed $property;

            public function __construct()
            {
                $this->property = fopen('php://memory', 'rb');
            }
        };

        $result = (string) $entity;

        $this->assertStringContainsString('{"error":', $result);
    }

    final public function testContentReturnsValues(): void
    {
        $entity = new class extends Outputable {
            public string $property1 = 'value1';

            public int $property2 = 123;
        };

        $expected = [
            'property1' => 'value1',
            'property2' => 123,
        ];

        $this->assertEquals($expected, $entity->content()->toArray());
    }

    final public function testContentWithEmptyOutputable(): void
    {
        $entity = new class extends Outputable {
        };

        $this->assertNull($entity->content());
    }

    final public function testPropertiesReturnsEmpty(): void
    {
        $entity = new class extends Outputable {
        };

        $this->assertEquals([], $entity->properties()->toArray());
    }

    final public function testExtractReturnsObjectVars(): void
    {
        $entity = new class extends Outputable {
            public string $createdBy = 'who';

            public int $MaxTimeAllowed = 123;
        };

        $expected = [
            'created_by' => 'who',
            'max_time_allowed' => 123,
        ];

        $this->assertEquals($expected, $entity->extract());
    }
}
