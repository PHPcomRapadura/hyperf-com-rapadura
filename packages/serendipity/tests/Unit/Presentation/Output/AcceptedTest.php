<?php

declare(strict_types=1);

namespace Serendipity\Test\Unit\Presentation\Output;

use Serendipity\Infrastructure\Testing\TestCase;
use Serendipity\Presentation\Output\Accepted;

/**
 * @internal
 * @coversNothing
 */
class AcceptedTest extends TestCase
{
    public function testShouldHaveTokenOnContent(): void
    {
        $token = $this->faker->faker->uuid();
        $output = new Accepted($token);
        $this->assertEquals($token, $output->content()->get('token'));
    }
}
