<?php

declare(strict_types=1);

namespace Tests\Integration\Presentation\Action\Game;

use App\Domain\Entity\Game;
use App\Infrastructure\Support\Presentation\Output\NotFound;
use App\Presentation\Action\Game\ReadGameAction;
use App\Presentation\Input\Game\ReadGameInput;
use Tests\Integration\IntegrationTestCase;

class ReadGameActionTest extends IntegrationTestCase
{
    protected array $truncate = ['games' => 'sleek'];

    final public function testShouldReadGame(): void
    {
        $values = $this->faker->fake(Game::class);
        $this->sleek->seed('games', $values->toArray());

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
