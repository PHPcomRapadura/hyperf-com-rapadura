<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Repository\Json;

use App\Domain\Entity\Command\GameCommand;
use App\Infrastructure\Repository\Json\JsonGameCommandRepository;
use Tests\Integration\IntegrationTestCase;

class JsonGameCommandRepositoryTest extends IntegrationTestCase
{
    protected array $truncate = ['games' => 'sleek'];

    public function testShouldPersistSuccessfully(): void
    {
        $repository = $this->make(JsonGameCommandRepository::class);
        $values = $this->faker->fake(GameCommand::class);
        $game = $this->mapper->map(GameCommand::class, $values);
        $id = $repository->persist($game);

        $this->sleek->has('games', [
            ['id', '=', $id],
        ]);
    }
}
