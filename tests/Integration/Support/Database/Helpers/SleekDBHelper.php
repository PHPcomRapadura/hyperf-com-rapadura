<?php

declare(strict_types=1);

namespace Tests\Integration\Support\Database\Helpers;

use App\Domain\Support\Values;
use App\Infrastructure\Support\Adapter\Serializing\DeserializerFactory;
use App\Infrastructure\Support\Adapter\Serializing\SerializerFactory;
use App\Infrastructure\Support\Persistence\SleekDB\SleekDBDatabaseFactory;
use JsonException;
use Tests\Integration\Support\Database\Helper;
use Tests\TestCase;

final readonly class SleekDBHelper implements Helper
{
    private SerializerFactory $serializerFactory;

    private DeserializerFactory $deserializerFactory;

    public function __construct(
        private SleekDBDatabaseFactory $factory,
        private TestCase $assertion,
    ) {
        $this->serializerFactory = new SerializerFactory();
        $this->deserializerFactory = new DeserializerFactory();
    }

    public function truncate(string $resource): void
    {
        $database = $this->factory->make($resource);
        $database->deleteBy(['_id', '>=', 0]);
    }

    public function seed(string $type, string $resource, array $override = []): Values
    {
        $database = $this->factory->make($resource);

        $fake = $this->assertion->faker->fake($type);
        $serializer = $this->serializerFactory->make($type);
        $instance = $serializer->serialize($fake->toArray());
        $deserializer = $this->deserializerFactory->make($type);
        $datum = $deserializer->deserialize($instance);
        $data = array_merge($datum, $override);

        $generatedId = $database->insert($data);
        return new Values(array_merge($data, ['_id' => $generatedId]));
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
