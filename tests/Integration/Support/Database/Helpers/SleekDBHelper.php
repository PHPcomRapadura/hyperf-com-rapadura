<?php

declare(strict_types=1);

namespace Tests\Integration\Support\Database\Helpers;

use App\Infrastructure\Support\Persistence\SleekDB\SleekDBDatabaseFactory;
use JsonException;
use Tests\Integration\Support\Database\Helper;
use Tests\TestCase;

final class SleekDBHelper implements Helper
{
    public function __construct(
        private readonly SleekDBDatabaseFactory $factory,
        private readonly TestCase $assertion,
    ) {
    }

    public function truncate(string $resource): void
    {
        $database = $this->factory->make($resource);
        $database->deleteBy(['_id', '>=', 0]);
    }

    public function seed(string $resource, array $data = []): array
    {
        $database = $this->factory->make($resource);
        return $database->insert($data);
    }

    public function has(string $resource, array $filters): void
    {
        $this->assertion->assertTrue(
            $this->count($resource, $filters) > 0,
            sprintf(
                'Failed to assert that the collection has the specified data. collection: %s. filter: %s',
                $resource,
                $this->json($filters),
            )
        );
    }

    public function hasNot(string $resource, array $filters): void
    {
        // TODO: Implement hasNot() method.
    }

    public function hasCount(int $expected, string $resource, array $filters): void
    {
        // TODO: Implement hasCount() method.
    }

    public function isEmpty(string $resource): void
    {
        // TODO: Implement isEmpty() method.
    }

    private function count(string $resource, array $filters = []): int
    {
        $database = $this->factory->make($resource);
        return count($database->findBy($filters));
    }

    private function json(array $filters): string
    {
        try {
            return json_encode($filters, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return $e->getMessage();
        }
    }
}
