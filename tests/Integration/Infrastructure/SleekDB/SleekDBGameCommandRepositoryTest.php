<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\SleekDB;

use App\Domain\Entity\Command\GameCommand;
use App\Domain\Entity\Game;
use App\Infrastructure\Repository\SleekDB\SleekDBGameCommandRepository;
use Tests\Integration\InfrastructureTestCase;
use Serendipity\Testing\Extension\BuilderExtension;

/**
 * @internal
 */
class SleekDBGameCommandRepositoryTest extends InfrastructureTestCase
{
    use BuilderExtension;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpResource('games', 'sleek');
    }

    public function testShouldPersistSuccessfully(): void
    {
        $repository = $this->make(SleekDBGameCommandRepository::class);
        $values = $this->faker()->fake(GameCommand::class);
        $game = $this->builder()->build(GameCommand::class, $values);
        $id = $repository->persist($game);

        $this->assertHas([['id', '=', $id]]);
    }

    public function testShouldDestroySuccessfully(): void
    {
        $repository = $this->make(SleekDBGameCommandRepository::class);

        $values = $this->seed(Game::class);
        $id = $values->get('id');

        $this->assertHasExactly(1, [['id', '=', $id]]);

        $repository->destroy($id);

        $this->assertHasNot([['id', '=', $id]]);
    }
}
