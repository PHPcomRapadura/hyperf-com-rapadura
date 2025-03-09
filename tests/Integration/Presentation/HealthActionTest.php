<?php

declare(strict_types=1);

namespace Tests\Integration\Presentation;

use App\Presentation\Action\HealthAction;
use App\Presentation\Input\HealthInput;
use Serendipity\Hyperf\Testing\Extension\InputExtension;
use Serendipity\Hyperf\Testing\Extension\LoggerExtension;
use Serendipity\Hyperf\Testing\Extension\MakeExtension;
use Serendipity\Testing\Extension\FakerExtension;
use Tests\ExtensibleTestCase;

/**
 * @internal
 */
final class HealthActionTest extends ExtensibleTestCase
{
    use MakeExtension;
    use InputExtension;
    use FakerExtension;
    use LoggerExtension;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpInput();
        $this->setUpLogger();
    }

    public function testHealthAction(): void
    {
        $message = $this->generator()->word();
        $input = $this->input(HealthInput::class, ['message' => $message]);
        $action = $this->make(HealthAction::class);
        $result = $action($input);
        $this->assertEquals($message, $result);
    }
}
