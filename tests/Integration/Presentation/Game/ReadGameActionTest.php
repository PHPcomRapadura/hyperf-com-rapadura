<?php

declare(strict_types=1);

namespace Tests\Integration\Presentation\Game;

use App\Domain\Entity\Game;
use App\Presentation\Action\Game\ReadGameAction;
use App\Presentation\Input\Game\ReadGameInput;
use Serendipity\Presentation\Output\NotFound;
use Serendipity\Presentation\Output\Ok;
use Tests\Integration\PresentationTestCase;

/**
 * @internal
 */
class ReadGameActionTest extends PresentationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpResource('games', 'sleek');
    }

    final public function testShouldReturnOk(): void
    {
        $values = $this->seed(Game::class);

        $input = $this->input(class: ReadGameInput::class, params: ['id' => $values->get('id')]);

        $action = $this->make(ReadGameAction::class);
        $actual = $action($input);

        $this->assertInstanceOf(Ok::class, $actual);
        $this->assertSame($values->get('id'), $actual->content()->id);
        $this->assertSame($values->get('name'), $actual->content()->name);
    }

    final public function testShouldReturnNotFound(): void
    {
        $input = $this->input(class: ReadGameInput::class, params: ['id' => $this->generator()->uuid()]);

        $action = $this->make(ReadGameAction::class);
        $actual = $action($input);

        $this->assertInstanceOf(NotFound::class, $actual);
    }
}
