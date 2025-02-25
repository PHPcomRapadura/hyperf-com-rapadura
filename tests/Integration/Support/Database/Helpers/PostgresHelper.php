<?php

declare(strict_types=1);

namespace Tests\Integration\Support\Database\Helpers;

use Hyperf\DB\DB as Database;
use Tests\Integration\Support\Database\Helper;
use Tests\TestCase;

use function Util\Type\Array\extractNumeric;
use function Util\Type\Cast\toArray;
use function Util\Type\Json\encode;

final class PostgresHelper implements Helper
{
    public function __construct(
        private readonly Database $database,
        private readonly TestCase $assertion,
    ) {
    }

    public function truncate(string $resource): void
    {
        $this->database->execute(sprintf("TRUNCATE TABLE %s CASCADE", $resource));
    }

    public function seed(string $resource, array $data = []): mixed
    {
        // TODO: Implement seed() method.
    }

    public function has(string $resource, array $filters): void
    {
        $count = $this->count($resource, $filters);
        $message = sprintf(
            "Expected to find at least one record in table '%s' with filters '%s'",
            $resource,
            $this->json($filters)
        );
        $this->assertion->assertTrue($count > 0, $message);
    }

    public function hasNot(string $resource, array $filters): void
    {
        $count = $this->count($resource, $filters);
        $message = sprintf(
            "Expected to not find any record in table '%s' with filters '%s'",
            $resource,
            $this->json($filters)
        );
        $this->assertion->assertSame($count, 0, $message);
    }

    public function hasCount(int $expected, string $resource, array $filters): void
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

    public function isEmpty(string $resource): void
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
