<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\SleekDB;

use App\Domain\Entity\Game;
use App\Infrastructure\Repository\SleekDB\SleekDBGameQueryRepository;
use Tests\Integration\InfrastructureTestCase;
use Serendipity\Testing\Extension\ManagedExtension;

use function Hyperf\Collection\collect;

/**
 * @internal
 */
class SleekDBGameQueryRepositoryTest extends InfrastructureTestCase
{
    use ManagedExtension;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpResource('games', 'sleek');
    }

    public function testShouldReadGameSuccessfully(): void
    {
        $values = $this->seed(Game::class);

        $repository = $this->make(SleekDBGameQueryRepository::class);
        $game = $repository->getGame($values->get('id'));
        $this->assertEquals($values->get('name'), $game->name);
    }

    final public function testShouldReturnNullWhenGameNotExists(): void
    {
        $id = $this->managed()->id();
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
        $this->seed(Game::class);
        $this->seed(Game::class);
        $values = $this->seed(Game::class);
        $this->seed(Game::class);
        $this->seed(Game::class);

        $repository = $this->make(SleekDBGameQueryRepository::class);
        $all = $repository->getGames()->all();
        $count = collect($all)
            ->filter(fn ($game) => $game->id === $values->get('id'))
            ->count();
        $this->assertEquals(1, $count);
    }

    public function testGetGamesContainsExpectedSlug(): void
    {
        $slug = $this->generator()->slug();
        $this->seed(Game::class);
        $this->seed(Game::class);
        $values = $this->seed(Game::class, ['slug' => $slug]);
        $this->seed(Game::class);
        $this->seed(Game::class);

        $repository = $this->make(SleekDBGameQueryRepository::class);
        $game = $repository
            ->getGames(['id' => $values->get('id')])
            ->current();
        $this->assertEquals($slug, $game->slug);
    }

    public function testGetGamesReturnsEmptyCollectionWhenNoGames(): void
    {
        $repository = $this->make(SleekDBGameQueryRepository::class);
        $games = $repository->getGames();
        $this->assertCount(0, $games);
    }
}
