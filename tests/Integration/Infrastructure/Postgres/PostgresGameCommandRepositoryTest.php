<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Postgres;

use App\Domain\Entity\Command\GameCommand;
use App\Domain\Entity\Game;
use App\Infrastructure\Repository\Postgres\PostgresGameCommandRepository;
use Serendipity\Domain\Exception\UniqueKeyViolationException;
use Serendipity\Testing\Extension\BuilderExtension;
use Tests\Integration\InfrastructureTestCase;

/**
 * @internal
 */
final class PostgresGameCommandRepositoryTest extends InfrastructureTestCase
{
    use BuilderExtension;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpResource('games', 'postgres');
    }

    public function testShouldPersistSuccessfully(): void
    {
        # ## Arrange
        // create an instance of Repository
        $repository = $this->make(PostgresGameCommandRepository::class);
        // generate fake values for Game
        $values = $this->faker()->fake(GameCommand::class);
        // build a new instance of Game to be persisted
        $game = $this->builder()->build(GameCommand::class, $values);

        # ## Act
        // call the method that is being tested
        $id = $repository->create($game);

        # ## Assert
        // check if there is a record on database with the same ID
        $this->assertHas(['id' => $id]);
    }

    public function testShouldRaiseUniqueKeyViolationExceptionOnDuplicateKey(): void
    {
        # ## Assert
        $this->expectException(UniqueKeyViolationException::class);

        # ## Arrange
        $repository = $this->make(PostgresGameCommandRepository::class);
        $values1 = $this->faker()->fake(GameCommand::class);
        $game1 = $this->builder()->build(GameCommand::class, $values1);
        $values2 = $this->faker()->fake(GameCommand::class, ['slug' => $values1->get('slug')]);
        $game2 = $this->builder()->build(GameCommand::class, $values2);

        # ## Act
        // call the same method twice to force the duplicity
        $repository->create($game1);
        $repository->create($game2);
    }

    public function testShouldUpdateSuccessfully(): void
    {
        // ## Arrange
        // Seed a game record in the database
        $values = $this->seed(Game::class);
        $originalId = $values->get('id');

        // Fake new values to update the record
        $newValues = $this->faker()->fake(GameCommand::class);
        $updatedGame = $this->builder()->build(GameCommand::class, $newValues);

        // Create an instance of the repository
        $repository = $this->make(PostgresGameCommandRepository::class);

        // ## Act
        // Call the update method
        $wasUpdated = $repository->update($originalId, $updatedGame);

        // ## Assert
        // Verify that the update method returned true
        $this->assertTrue($wasUpdated);

        // Assert that the record in the database matches the updated values
        $this->assertHas([
            'id' => $originalId,
            'name' => $newValues->get('name'),
            'slug' => $newValues->get('slug'),
        ]);
    }

    public function testShouldReturnFalseIfRecordDoesNotExist(): void
    {
        // ## Arrange
        // Create a non-existent ID
        $nonExistentId = $this->faker()->uuid();

        // Fake a GameCommand object
        $newValues = $this->faker()->fake(GameCommand::class);
        $game = $this->builder()->build(GameCommand::class, $newValues);

        // Create an instance of the repository
        $repository = $this->make(PostgresGameCommandRepository::class);

        // ## Act
        // Attempt to update a record that does not exist
        $wasUpdated = $repository->update($nonExistentId, $game);

        // ## Assert
        // Verify that the update method returned false
        $this->assertFalse($wasUpdated);
    }

    public function testShouldDestroySuccessfully(): void
    {
        $values = $this->seed(Game::class);
        $id = $values->get('id');
        $repository = $this->make(PostgresGameCommandRepository::class);
        $repository->delete($id);
        $this->assertHasNot(['id' => $id]);
    }
}
