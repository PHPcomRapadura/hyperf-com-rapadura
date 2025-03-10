<?php

declare(strict_types=1);

namespace Tests\Integration\Presentation\Game;

use App\Domain\Entity\Game;
use App\Presentation\Action\Game\DeleteGameAction;
use App\Presentation\Input\Game\GameInput;
use Serendipity\Presentation\Output\Accepted;
use Serendipity\Presentation\Output\Fail\UnprocessableEntity;
use Tests\Integration\PresentationTestCase;

/**
 * @internal
 */
final class DeleteGameActionTest extends PresentationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpResource('games', 'sleek');
    }

    public function testDeleteGameSuccessfully(): void
    {
        $values = $this->seed(Game::class);
        $id = $values->get('id');

        $input = $this->input(class: GameInput::class, params: ['id' => $id]);

        $action = $this->make(DeleteGameAction::class);
        $actual = $action($input);

        $this->assertInstanceOf(Accepted::class, $actual);
        $this->assertSame($id, $actual->properties()->get('token'));

        $this->assertHasNot([['id', '=', $id]]);
    }

    public function testDeleteGameShouldReturnUnprocessableEntity(): void
    {
        $id = $this->generator()->uuid();

        $input = $this->input(class: GameInput::class, params: ['id' => $id]);

        $action = $this->make(DeleteGameAction::class);
        $actual = $action($input);

        $this->assertInstanceOf(UnprocessableEntity::class, $actual);
        $this->assertSame($id, $actual->content());
    }
}
