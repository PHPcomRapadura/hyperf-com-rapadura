<?php

declare(strict_types=1);

namespace BackboneTest\Unit\Presentation\Output;

use Backbone\Infrastructure\Testing\TestCase;
use Backbone\Presentation\Output\Created;

/**
 * @internal
 * @coversNothing
 */
final class CreatedTest extends TestCase
{
    public function testShouldHaveIdOnContent(): void
    {
        $id = $this->faker->faker->id();
        $output = new Created($id);
        $this->assertEquals($id, $output->content()->get('id'));
    }
}
