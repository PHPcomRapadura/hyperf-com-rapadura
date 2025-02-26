<?php

declare(strict_types=1);

namespace Tests\Integration\Presentation\Action;

use App\Presentation\Action\HomeAction;
use App\Presentation\Input\HomeInput;
use Serendipity\Infrastructure\Testing\TestCase;

class HomeActionTest extends TestCase
{
    public function testShouldBeSuccessful(): void
    {
        $input = $this->input(HomeInput::class, ['message' => 'Hello World']);

        $action = $this->make(HomeAction::class);
        $result = $action($input);

        $this->assertEquals('POST', $result['method']);
        $this->assertEquals('Hello World', $result['message']);
    }
}
