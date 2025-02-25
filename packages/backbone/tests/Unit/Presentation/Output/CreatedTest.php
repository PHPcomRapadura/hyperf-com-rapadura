<?php

declare(strict_types=1);

namespace Backbone\Test\Unit\Presentation\Output;

use Backbone\Presentation\Output\Created;
use Tests\Support\TestCase;

final class CreatedTest extends TestCase
{
    public function testShouldHaveIdOnContent(): void
    {
        $id = $this->faker->faker->id();
        $output = new Created($id);
        $this->assertEquals($id, $output->content()->get('id'));
    }
}
