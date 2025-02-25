<?php

declare(strict_types=1);

namespace BackboneTest\Unit\Presentation\Output;

use Backbone\Presentation\Output\NoContent;
use Backbone\Infrastructure\Testing\TestCase;

final class NoContentTest extends TestCase
{
    public function testShouldHaveIdOnContent(): void
    {
        $word = $this->faker->faker->word();
        $properties = ['word' => $word];
        $output = new NoContent($properties);
        $this->assertNull($output->content());
        $this->assertEquals($properties, $output->properties()->toArray());
    }
}
