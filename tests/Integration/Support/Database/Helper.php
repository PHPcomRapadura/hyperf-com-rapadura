<?php

namespace Tests\Integration\Support\Database;

use App\Domain\Support\Values;

interface Helper
{
    public function truncate(string $resource): void;

    public function seed(string $type, string $resource, array $override = []): Values;

    public function has(string $resource, array $filters): void;

    public function hasNot(string $resource, array $filters): void;

    public function hasCount(int $expected, string $resource, array $filters): void;

    public function isEmpty(string $resource): void;
}
