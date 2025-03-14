<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Postgres;

use App\Domain\Entity\Game;
use App\Infrastructure\Repository\Postgres\PostgresGameQueryRepository;
use Serendipity\Testing\Extension\ManagedExtension;
use Tests\Integration\InfrastructureTestCase;

use function Hyperf\Collection\collect;

/**
 * @internal
 */
class PostgresGameQueryRepositoryTest extends InfrastructureTestCase
{
    use ManagedExtension;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpResource('games', 'postgres');
    }

    public function testShouldReadGameSuccessfully(): void
    {
        $values = $this->seed(Game::class);

        $repository = $this->make(PostgresGameQueryRepository::class);
        $game = $repository->read($values->get('id'));
        $this->assertEquals($values->get('name'), $game->name);
    }

    final public function testShouldReturnNullWhenGameNotExists(): void
    {
        $id = $this->managed()->id();
        $repository = $this->make(PostgresGameQueryRepository::class);
        $this->assertNull($repository->read($id));
    }

    public function testGetGamesReturnsGameCollection(): void
    {
        $this->seed(Game::class);
        $this->seed(Game::class);

        $repository = $this->make(PostgresGameQueryRepository::class);
        $games = $repository->search();

        $this->assertCount(2, $games);
    }

    public function testGetGamesContainsExpectedGames(): void
    {
        $values = $this->seed(Game::class);
        $this->seed(Game::class);

        $repository = $this->make(PostgresGameQueryRepository::class);
        $all = $repository->search()->all();
        $count = collect($all)
            ->filter(fn ($game) => $game->id === $values->get('id'))
            ->count();
        $this->assertEquals(1, $count);
    }

    public function testGetGamesReturnsEmptyCollectionWhenNoGames(): void
    {
        $repository = $this->make(PostgresGameQueryRepository::class);
        $games = $repository->search();
        $this->assertCount(0, $games);
    }
}
