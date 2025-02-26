<?php

declare(strict_types=1);

namespace Serendipity\Test\Unit\Presentation\Output;

use Serendipity\Infrastructure\Testing\TestCase;
use Serendipity\Presentation\Output\NoContent;

/**
 * @internal
 * @coversNothing
 */
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
