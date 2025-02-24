<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Support\Presentation\Output;

use App\Infrastructure\Support\Presentation\Output\Created;
use Tests\TestCase;

final class CreatedTest extends TestCase
{
    public function testShouldHaveIdOnContent(): void
    {
        $id = $this->faker->faker->id();
        $output = new Created($id);
        $this->assertEquals($id, $output->content()->get('id'));
    }
}
