<?php

declare(strict_types=1);

namespace Tests\Integration\Presentation\Game;

use App\Application\Exception\ExportGamesFailedException;
use App\Domain\Entity\Game;
use App\Presentation\Action\Game\ExportGameAction;
use App\Presentation\Input\Game\ExportGamesInput;
use Tests\Integration\PresentationTestCase;

/**
 * @internal
 */
final class ExportGameActionTest extends PresentationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpResource('games', 'sleek');
    }

    public function testExportGameSuccessfully(): void
    {
        $values = $this->seed(Game::class);
        $slug = $values->get('slug');

        $input = $this->input(class: ExportGamesInput::class, params: ['slug' => $slug]);

        $action = $this->make(ExportGameAction::class);
        $actual = $action($input);

        $this->assertSame($slug, $actual->slug);
    }

    public function testExportGameShouldReturnUnprocessableEntity(): void
    {
        $this->expectException(ExportGamesFailedException::class);
        $this->expectExceptionMessage('Game not found');

        $slug = $this->generator()->slug();

        $input = $this->input(class: ExportGamesInput::class, params: ['slug' => $slug]);

        $action = $this->make(ExportGameAction::class);
        $action($input);
    }
}
