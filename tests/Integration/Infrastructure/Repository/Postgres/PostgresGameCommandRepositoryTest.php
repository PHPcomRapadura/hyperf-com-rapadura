<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Repository\Postgres;

use App\Domain\Entity\Command\GameCommand;
use App\Infrastructure\Repository\Postgres\PostgresGameCommandRepository;
use Serendipity\Infrastructure\Testing\IntegrationTestCase;

class PostgresGameCommandRepositoryTest extends IntegrationTestCase
{
    protected ?string $helper = 'postgres';

    protected ?string $resource = 'games';

    public function testShouldPersistSuccessfully(): void
    {
        $repository = $this->make(PostgresGameCommandRepository::class);
        $values = $this->faker->fake(GameCommand::class);
        $game = $this->mapper->build(GameCommand::class, $values);
        $id = $repository->persist($game);

        $this->assertHas(['id' => $id]);
    }
}
