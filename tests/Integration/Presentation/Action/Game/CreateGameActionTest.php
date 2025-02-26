<?php

declare(strict_types=1);

namespace Tests\Integration\Presentation\Action\Game;

use App\Domain\Entity\Command\GameCommand;
use App\Presentation\Action\Game\CreateGameAction;
use App\Presentation\Input\Game\CreateGameInput;
use Serendipity\Infrastructure\Testing\IntegrationTestCase;
use Serendipity\Presentation\Output\Accepted;

class CreateGameActionTest extends IntegrationTestCase
{
    protected array $truncate = ['games' => 'sleek'];

    final public function testCreateGameSuccessfully(): void
    {
        $values = $this->faker->fake(GameCommand::class);
        $input = $this->input(CreateGameInput::class, $values->toArray());
        $action = $this->make(CreateGameAction::class);
        $result = $action($input);
        $this->assertInstanceOf(Accepted::class, $result);
        $this->assertNotEmpty($result->content()->get('token'));
    }
}
