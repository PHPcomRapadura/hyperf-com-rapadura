<?php

declare(strict_types=1);

namespace Tests\Integration\Presentation\Action\Game;

use App\Domain\Entity\Game;
use App\Presentation\Action\Game\ReadGameAction;
use App\Presentation\Input\Game\ReadGameInput;
use Backbone\Infrastructure\Testing\IntegrationTestCase;
use Backbone\Presentation\Output\NotFound;

class ReadGameActionTest extends IntegrationTestCase
{
    protected array $truncate = ['games' => 'sleek'];

    final public function testShouldReadGame(): void
    {
        $values = $this->sleek->seed(Game::class, 'games');

        $input = $this->input(class: ReadGameInput::class, params: ['id' => $values->get('id')]);

        $action = $this->make(ReadGameAction::class);
        $actual = $action($input);

        $this->assertSame($values->get('name'), $actual->name);
    }

    final public function testGetGameBySlugReturnsNotFound(): void
    {
        $input = $this->input(class: ReadGameInput::class, params: ['id' => $this->faker->generator->id()]);

        $action = $this->make(ReadGameAction::class);
        $actual = $action($input);

        $this->assertInstanceOf(NotFound::class, $actual);
    }
}
