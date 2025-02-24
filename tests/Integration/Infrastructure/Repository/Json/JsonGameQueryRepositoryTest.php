<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Repository\Json;

use App\Domain\Entity\Game;
use App\Infrastructure\Repository\Json\JsonGameQueryRepository;
use Tests\Integration\IntegrationTestCase;

use function Hyperf\Collection\collect;

class JsonGameQueryRepositoryTest extends IntegrationTestCase
{
    protected array $truncate = ['games' => 'sleek'];

    public function testShouldReadGameSuccessfully(): void
    {
        $values = $this->faker->fake(Game::class);
        $this->sleek->seed('games', $values->toArray());

        $repository = $this->make(JsonGameQueryRepository::class);
        $game = $repository->getGame($values->get('id'));
        $this->assertEquals($values->get('name'), $game->name);
    }

    final public function testShouldReturnNullWhenGameNotExists(): void
    {
        $id = $this->faker->generator->id();
        $repository = $this->make(JsonGameQueryRepository::class);
        $this->assertNull($repository->getGame($id));
    }

    public function testGetGamesReturnsGameCollection(): void
    {
        $this->sleek->seed('games', $this->faker->fake(Game::class)->toArray());
        $this->sleek->seed('games', $this->faker->fake(Game::class)->toArray());

        $repository = $this->make(JsonGameQueryRepository::class);
        $games = $repository->getGames();

        $this->assertCount(2, $games);
    }

    public function testGetGamesContainsExpectedGames(): void
    {
        $values = $this->faker->fake(Game::class);
        $this->sleek->seed('games', $values->toArray());

        $repository = $this->make(JsonGameQueryRepository::class);
        $all = $repository->getGames()->all();
        $count = collect($all)
            ->filter(fn ($game) => $game->id === $values->get('id'))
            ->count();
        $this->assertEquals(1, $count);
    }

    public function testGetGamesReturnsEmptyCollectionWhenNoGames(): void
    {
        $repository = $this->make(JsonGameQueryRepository::class);
        $games = $repository->getGames();
        $this->assertCount(0, $games);
    }
}
