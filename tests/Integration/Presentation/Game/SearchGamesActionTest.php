<?php

declare(strict_types=1);

namespace Tests\Integration\Presentation\Game;

use App\Domain\Entity\Game;
use App\Presentation\Action\Game\SearchGamesAction;
use App\Presentation\Input\Game\SearchGamesInput;
use Serendipity\Presentation\Output\Ok;
use Tests\Integration\PresentationTestCase;

/**
 * @internal
 */
final class SearchGamesActionTest extends PresentationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpResource('games', 'sleek');
    }

    public function testShouldReturnGames(): void
    {
        $slug = $this->generator()->slug();
        $this->seed(Game::class, ['slug' => $slug]);
        $this->seed(Game::class, ['slug' => $slug]);
        $this->seed(Game::class, ['slug' => $slug]);

        $input = $this->input(class: SearchGamesInput::class, queryParams: ['slug' => $slug]);

        $action = $this->make(SearchGamesAction::class);
        $actual = $action($input);

        $this->assertInstanceOf(Ok::class, $actual);
        $this->assertCount(3, $actual->content());
        $this->assertEquals($slug, $actual->content()[0]->slug);
    }

    public function testShouldReturnEmptyArray(): void
    {
        $input = $this->input(class: SearchGamesInput::class, params: ['id' => $this->generator()->uuid()]);

        $action = $this->make(SearchGamesAction::class);
        $actual = $action($input);

        $this->assertInstanceOf(Ok::class, $actual);
        $this->assertCount(0, $actual->content());
    }
}
