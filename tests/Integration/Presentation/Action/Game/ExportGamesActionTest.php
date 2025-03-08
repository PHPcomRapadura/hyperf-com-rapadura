<?php

declare(strict_types=1);

namespace Tests\Integration\Presentation\Action\Game;

use App\Domain\Entity\Game;
use App\Presentation\Action\Game\ExportGamesAction;
use App\Presentation\Input\Game\ExportGamesInput;
use Serendipity\Infrastructure\Testing\IntegrationTestCase;

class ExportGamesActionTest extends IntegrationTestCase
{
    protected ?string $helper = 'sleek';

    protected ?string $resource = 'games';

    final public function testCreateGameSuccessfully(): void
    {
        $game = $this->faker->fake(Game::class);
        $this->seed(Game::class, $game->toArray());
        $this->seed(Game::class);

        $input = $this->input(class: ExportGamesInput::class, params: ['slug' => $game->get('slug')]);
        $action = $this->make(ExportGamesAction::class);
        $result = $action($input);
        $this->assertEquals($game->get('name'), $result->name);
    }
}
