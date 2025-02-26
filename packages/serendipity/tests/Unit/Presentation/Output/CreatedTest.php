<?php

declare(strict_types=1);

namespace Serendipity\Test\Unit\Presentation\Output;

use Serendipity\Infrastructure\Testing\TestCase;
use Serendipity\Presentation\Output\Created;

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
