<?php

declare(strict_types=1);

namespace Backbone\Test\Unit\Presentation\Output;

use Backbone\Presentation\Output\Accepted;
use Tests\Support\TestCase;

class AcceptedTest extends TestCase
{
    public function testShouldHaveTokenOnContent(): void
    {
        $token = $this->faker->faker->uuid();
        $output = new Accepted($token);
        $this->assertEquals($token, $output->content()->get('token'));
    }
}
