<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Support\Presentation\Output;

use App\Infrastructure\Support\Presentation\Output\Accepted;
use Tests\TestCase;

class AcceptedTest extends TestCase
{
    public function testShouldHaveTokenOnContent(): void
    {
        $token = $this->faker->faker->uuid();
        $output = new Accepted($token);
        $this->assertEquals($token, $output->content()->get('token'));
    }
}
