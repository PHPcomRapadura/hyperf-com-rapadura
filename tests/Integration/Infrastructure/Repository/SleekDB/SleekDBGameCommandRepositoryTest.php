<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Repository\SleekDB;

use App\Domain\Entity\Command\GameCommand;
use App\Infrastructure\Repository\SleekDB\SleekDBGameCommandRepository;
use Serendipity\Infrastructure\Testing\IntegrationTestCase;

class SleekDBGameCommandRepositoryTest extends IntegrationTestCase
{
    protected ?string $helper = 'sleek';

    protected ?string $resource = 'games';

    public function testShouldPersistSuccessfully(): void
    {
        $repository = $this->make(SleekDBGameCommandRepository::class);
        $values = $this->faker->fake(GameCommand::class);
        $game = $this->mapper->build(GameCommand::class, $values);
        $id = $repository->persist($game);

        $this->assertHas([['id', '=', $id]]);
    }
}
