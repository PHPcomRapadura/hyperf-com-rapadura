<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Persistence\Testing;

use Backbone\Domain\Support\Values;
use Backbone\Infrastructure\Persistence\Serializing\RelationalDeserializerFactory;
use Backbone\Infrastructure\Persistence\Serializing\RelationalSerializerFactory;
use Hyperf\DB\DB as Database;
use Tests\Support\TestCase;

use function Backbone\Type\Array\extractNumeric;
use function Backbone\Type\Cast\toArray;
use function Backbone\Type\Json\encode;

final readonly class PostgresHelper implements Helper
{
    private RelationalSerializerFactory $serializerFactory;

    private RelationalDeserializerFactory $deserializerFactory;

    public function __construct(
        private Database $database,
        private TestCase $assertion,
    ) {
        $this->serializerFactory = new RelationalSerializerFactory();
        $this->deserializerFactory = new RelationalDeserializerFactory();
    }

    public function truncate(string $resource): void
    {
        $this->database->execute(sprintf("delete from %s where true", $resource));
    }

    public function seed(string $type, string $resource, array $override = []): Values
    {
        $fake = $this->assertion->faker->fake($type);
        $serializer = $this->serializerFactory->make($type);
        $instance = $serializer->serialize($fake->toArray());
        $deserializer = $this->deserializerFactory->make($type);
        $datum = $deserializer->deserialize($instance);
        $data = array_merge($datum, $override);
        $fields = array_keys($data);
        $fields = array_map(fn (string $field) => sprintf('"%s"', $field), $fields);
        $columns = implode(',', $fields);
        $values = str_repeat('?,', count($fields) - 1) . '?';

        $query = sprintf('insert into "%s" (%s) values (%s)', $resource, $columns, $values);
        $bindings = array_values($data);

        $this->database->execute($query, $bindings);
        return new Values($data);
    }

    public function assertHas(string $resource, array $filters): void
    {
        $count = $this->count($resource, $filters);
        $message = sprintf(
            "Expected to find at least one record in table '%s' with filters '%s'",
            $resource,
            $this->json($filters)
        );
        $this->assertion->assertTrue($count > 0, $message);
    }

    public function assertHasNot(string $resource, array $filters): void
    {
        $count = $this->count($resource, $filters);
        $message = sprintf(
            "Expected to not find any record in table '%s' with filters '%s'",
            $resource,
            $this->json($filters)
        );
        $this->assertion->assertSame($count, 0, $message);
    }

    public function assertHasCount(int $expected, string $resource, array $filters): void
    {
        $count = $this->count($resource, $filters);
        $message = sprintf(
            "Expected to find %d records in table '%s' with filters '%s', but found %d",
            $expected,
            $resource,
            $this->json($filters),
            $count
        );
        $this->assertion->assertEquals($expected, $count, $message);
    }

    public function assertIsEmpty(string $resource): void
    {
        // TODO: Implement isEmpty() method.
    }

    protected function count(string $table, array $filters): int
    {
        $callback = function (string $key, mixed $value) {
            if ($value === null) {
                return sprintf('"%s" is null', $key);
            }
            return sprintf('"%s" = ?', $key);
        };
        $wildcards = array_map($callback, array_keys($filters), array_values($filters));
        $where = implode(' and ', $wildcards);
        $query = sprintf(
            "select count(*) as count from %s where %s",
            sprintf('"%s"', $table),
            $where
        );
        $bindings = array_values(array_filter($filters, fn (mixed $value) => $value !== null));
        $result = toArray($this->database->fetch($query, $bindings));
        return (int) extractNumeric($result, 'count', 0);
    }

    protected function json(array $filters): ?string
    {
        return encode($filters);
    }
}
