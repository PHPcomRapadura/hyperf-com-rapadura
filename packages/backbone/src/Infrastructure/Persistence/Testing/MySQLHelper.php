<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Persistence\Testing;

use Backbone\Domain\Support\Values;
use Hyperf\DB\DB as Database;
use Tests\Support\TestCase;

final readonly class MySQLHelper implements Helper
{
    public function __construct(
        private Database $database,
        private TestCase $assertion,
    ) {
    }

    public function truncate(string $resource): void
    {
        // TODO: Implement truncate() method.
    }

    public function seed(string $type, string $resource, array $override = []): Values
    {
        // TODO: Implement seed() method.
    }

    public function assertHas(string $resource, array $filters): void
    {
        // TODO: Implement has() method.
    }

    public function assertHasNot(string $resource, array $filters): void
    {
        // TODO: Implement hasNot() method.
    }

    public function assertHasCount(int $expected, string $resource, array $filters): void
    {
        // TODO: Implement hasCount() method.
    }

    public function assertIsEmpty(string $resource): void
    {
        // TODO: Implement isEmpty() method.
    }
}
