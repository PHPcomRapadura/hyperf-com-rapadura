<?php

declare(strict_types=1);

namespace BackboneTest\Unit\Infrastructure\Persistence;

use Backbone\Domain\Exception\GeneratingException;
use Backbone\Infrastructure\Persistence\Generator;
use Backbone\Infrastructure\Testing\TestCase;

/**
 * @internal
 * @coversNothing
 */
class GeneratorTest extends TestCase
{
    final public function testId(): void
    {
        $generator = new Generator();
        $id = $generator->id();
        $this->assertIsString($id);
        $this->assertGreaterThanOrEqual(4, strlen($id));
        $this->assertLessThanOrEqual(32, strlen($id));
    }

    final public function testNow(): void
    {
        $generator = new Generator();
        $now = $generator->now();
        $this->assertIsString($now);
    }

    final public function testIdWithLength(): void
    {
        $this->expectException(GeneratingException::class);
        $this->expectExceptionMessage('Error generating "id": "maxLength: cannot be less than 4 or greater than 32."');
        $generator = new Generator(0);
        $generator->id();
    }
}
