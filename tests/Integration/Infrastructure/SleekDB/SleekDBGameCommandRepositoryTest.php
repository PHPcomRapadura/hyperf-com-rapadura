<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\SleekDB;

use App\Domain\Entity\Command\GameCommand;
use App\Domain\Entity\Game;
use App\Infrastructure\Repository\SleekDB\SleekDBGameCommandRepository;
use Serendipity\Testing\Extension\BuilderExtension;
use Tests\Integration\InfrastructureTestCase;

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
        $id = $repository->create($game);

        $this->assertHas([['id', '=', $id]]);
    }

    public function testShouldUpdateSuccessfully(): void
    {
        // ## Arrange
        $repository = $this->make(SleekDBGameCommandRepository::class);

        // Seed a game record in the SleekDB database
        $values = $this->seed(Game::class);
        $originalId = $values->get('id');

        // Generate new values to update the record
        $newValues = $this->faker()->fake(GameCommand::class);
        $updatedGame = $this->builder()->build(GameCommand::class, $newValues);

        // ## Act
        $wasUpdated = $repository->update($originalId, $updatedGame);

        // ## Assert
        // Ensure the update method returned true
        $this->assertTrue($wasUpdated);

        // Verify that the data in the DB was updated correctly
        $this->assertHas(
            [
                ['id', '=', $originalId],
                ['name', '=', $newValues->get('name')],
                ['slug', '=', $newValues->get('slug')],
            ]
        );
    }

    public function testShouldReturnFalseIfRecordDoesNotExist(): void
    {
        // ## Arrange
        $repository = $this->make(SleekDBGameCommandRepository::class);

        // Generate a non-existent ID
        $nonExistentId = $this->faker()->uuid();

        // Create fake new data for a record
        $newValues = $this->faker()->fake(GameCommand::class);
        $game = $this->builder()->build(GameCommand::class, $newValues);

        // ## Act
        $wasUpdated = $repository->update($nonExistentId, $game);

        // ## Assert
        // Ensure the update method returned false
        $this->assertFalse($wasUpdated);
    }

    public function testShouldDestroySuccessfully(): void
    {
        $repository = $this->make(SleekDBGameCommandRepository::class);

        $values = $this->seed(Game::class);
        $id = $values->get('id');

        $this->assertHasExactly(1, [['id', '=', $id]]);

        $repository->delete($id);

        $this->assertHasNot([['id', '=', $id]]);
    }
}
