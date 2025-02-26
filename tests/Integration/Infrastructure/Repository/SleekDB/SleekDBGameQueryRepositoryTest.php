<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Repository\SleekDB;

use App\Domain\Entity\Game;
use App\Infrastructure\Repository\SleekDB\SleekDBGameQueryRepository;
use Serendipity\Infrastructure\Testing\IntegrationTestCase;

use function Hyperf\Collection\collect;

class SleekDBGameQueryRepositoryTest extends IntegrationTestCase
{
    protected ?string $helper = 'sleek';

    protected ?string $resource = 'games';

    public function testShouldReadGameSuccessfully(): void
    {
        $values = $this->seed(Game::class);

        $repository = $this->make(SleekDBGameQueryRepository::class);
        $game = $repository->getGame($values->get('id'));
        $this->assertEquals($values->get('name'), $game->name);
    }

    final public function testShouldReturnNullWhenGameNotExists(): void
    {
        $id = $this->faker->generator->id();
        $repository = $this->make(SleekDBGameQueryRepository::class);
        $this->assertNull($repository->getGame($id));
    }

    public function testGetGamesReturnsGameCollection(): void
    {
        $this->seed(Game::class);
        $this->seed(Game::class);

        $repository = $this->make(SleekDBGameQueryRepository::class);
        $games = $repository->getGames();

        $this->assertCount(2, $games);
    }

    public function testGetGamesContainsExpectedGames(): void
    {
        $values = $this->seed(Game::class);

        $repository = $this->make(SleekDBGameQueryRepository::class);
        $all = $repository->getGames()->all();
        $count = collect($all)
            ->filter(fn ($game) => $game->id === $values->get('id'))
            ->count();
        $this->assertEquals(1, $count);
    }

    public function testGetGamesReturnsEmptyCollectionWhenNoGames(): void
    {
        $repository = $this->make(SleekDBGameQueryRepository::class);
        $games = $repository->getGames();
        $this->assertCount(0, $games);
    }
}
