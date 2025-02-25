<?php

declare(strict_types=1);

namespace Tests\Integration\Support\Database\Helpers;

use Hyperf\DB\DB as Database;
use Tests\Integration\Support\Database\Helper;
use Tests\TestCase;

class MySQLHelper implements Helper
{
    public function __construct(
        private readonly Database $database,
        private readonly TestCase $assertion,
    ) {
    }

    public function truncate(string $resource): void
    {
        // TODO: Implement truncate() method.
    }

    public function seed(string $resource, array $data = []): mixed
    {
        // TODO: Implement seed() method.
    }

    public function has(string $resource, array $filters): void
    {
        // TODO: Implement has() method.
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
}
