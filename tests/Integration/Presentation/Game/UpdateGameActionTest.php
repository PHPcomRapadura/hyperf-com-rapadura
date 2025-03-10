<?php

declare(strict_types=1);

namespace Tests\Integration\Presentation\Game;

use App\Domain\Entity\Game;
use App\Presentation\Action\Game\UpdateGameAction;
use App\Presentation\Input\Game\UpdateGameInput;
use Serendipity\Presentation\Output\Accepted;
use Serendipity\Presentation\Output\Fail\UnprocessableEntity;
use Tests\Integration\PresentationTestCase;

/**
 * @internal
 */
final class UpdateGameActionTest extends PresentationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpResource('games', 'sleek');
    }

    public function testUpdateGameSuccessfully(): void
    {
        $values = $this->seed(Game::class);
        $id = $values->get('id');

        $generator = $this->generator();
        $name = $generator->name();
        $slug = $generator->slug();
        $data = $generator->words();
        $parsedBody = [
            'name' => $name,
            'slug' => $slug,
            'data' => $data,
        ];
        $params = ['id' => $id];
        $input = $this->input(class: UpdateGameInput::class, parsedBody: $parsedBody, params: $params);

        $action = $this->make(UpdateGameAction::class);
        $actual = $action($input);

        $this->assertInstanceOf(Accepted::class, $actual);
        $this->assertSame($id, $actual->properties()->get('token'));

        $this->assertHas([
            ['id', '=', $id],
            ['name', '=', $name],
            ['slug', '=', $slug],
            ['data', '=', $data],
        ]);
    }

    public function testUpdateGameShouldReturnUnprocessableEntity(): void
    {
        $id = $this->generator()->uuid();
        $generator = $this->generator();
        $parsedBody = [
            'name' => $generator->name(),
            'slug' => $generator->slug(),
            'data' => $generator->words(),
        ];
        $params = ['id' => $id];
        $input = $this->input(class: UpdateGameInput::class, parsedBody: $parsedBody, params: $params);

        $action = $this->make(UpdateGameAction::class);
        $actual = $action($input);

        $this->assertInstanceOf(UnprocessableEntity::class, $actual);
        $this->assertSame($id, $actual->content());
    }
}
