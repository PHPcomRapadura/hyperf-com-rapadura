<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Repository\Postgres;

use App\Domain\Entity\Command\GameCommand;
use App\Infrastructure\Repository\Postgres\PostgresGameCommandRepository;
use Tests\Integration\IntegrationTestCase;

class PostgresGameCommandRepositoryTest extends IntegrationTestCase
{
    protected array $truncate = ['games' => 'postgres'];

    public function testShouldPersistSuccessfully(): void
    {
        $repository = $this->make(PostgresGameCommandRepository::class);
        $values = $this->faker->fake(GameCommand::class);
        $game = $this->mapper->build(GameCommand::class, $values);
        $id = $repository->persist($game);

        $this->postgres->assertHas('games', [
            'id' => $id,
        ]);
    }
}
