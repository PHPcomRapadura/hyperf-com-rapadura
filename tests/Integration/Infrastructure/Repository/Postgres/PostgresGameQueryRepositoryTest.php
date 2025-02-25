<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Repository\Postgres;

use App\Domain\Entity\Game;
use App\Infrastructure\Repository\Postgres\PostgresGameQueryRepository;
use Tests\Integration\IntegrationTestCase;

use function Hyperf\Collection\collect;
use function Util\Type\Json\encode;

class PostgresGameQueryRepositoryTest extends IntegrationTestCase
{
    protected array $truncate = ['games' => 'postgres'];

    public function testShouldReadGameSuccessfully(): void
    {
        $values = $this->faker->fake(Game::class);
        $data = $values->toArray();
        $this->postgres->seed('games', $data);

        $repository = $this->make(PostgresGameQueryRepository::class);
        $game = $repository->getGame($values->get('id'));
        $this->assertEquals($values->get('name'), $game->name);
    }

    final public function testShouldReturnNullWhenGameNotExists(): void
    {
        $id = $this->faker->generator->id();
        $repository = $this->make(PostgresGameQueryRepository::class);
        $this->assertNull($repository->getGame($id));
    }

    public function testGetGamesReturnsGameCollection(): void
    {
        $this->postgres->seed('games', $this->faker->fake(Game::class)->toArray());
        $this->postgres->seed('games', $this->faker->fake(Game::class)->toArray());

        $repository = $this->make(PostgresGameQueryRepository::class);
        $games = $repository->getGames();

        $this->assertCount(2, $games);
    }

    public function testGetGamesContainsExpectedGames(): void
    {
        $values = $this->faker->fake(Game::class);
        $data = $values->toArray();
        $data['data'] = encode($data['data']);
        $this->postgres->seed('games', $data);

        $repository = $this->make(PostgresGameQueryRepository::class);
        $all = $repository->getGames()->all();
        $count = collect($all)
            ->filter(fn ($game) => $game->id === $values->get('id'))
            ->count();
        $this->assertEquals(1, $count);
    }

    public function testGetGamesReturnsEmptyCollectionWhenNoGames(): void
    {
        $repository = $this->make(PostgresGameQueryRepository::class);
        $games = $repository->getGames();
        $this->assertCount(0, $games);
    }
}
