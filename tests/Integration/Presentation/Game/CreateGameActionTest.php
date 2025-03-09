<?php

declare(strict_types=1);

namespace Tests\Integration\Presentation\Game;

use App\Domain\Entity\Command\GameCommand;
use App\Presentation\Action\Game\CreateGameAction;
use App\Presentation\Input\Game\CreateGameInput;
use Serendipity\Presentation\Output\Accepted;
use Tests\Integration\PresentationTestCase;

/**
 * @internal
 */
class CreateGameActionTest extends PresentationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpResource('games', 'sleek');
    }

    final public function testCreateGameSuccessfully(): void
    {
        $values = $this->faker()->fake(GameCommand::class);
        $input = $this->input(CreateGameInput::class, $values->toArray());
        $action = $this->make(CreateGameAction::class);
        $result = $action($input);
        $this->assertInstanceOf(Accepted::class, $result);
        $this->assertIsString($result->content());
    }
}
