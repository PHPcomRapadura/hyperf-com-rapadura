<?php

namespace Tests\Integration\Support\Database;

interface Helper
{
    public function truncate(string $resource): void;

    public function seed(string $resource, array $data = []): mixed;

    public function has(string $resource, array $filters): void;

    public function hasNot(string $resource, array $filters): void;

    public function hasCount(int $expected, string $resource, array $filters): void;

    public function isEmpty(string $resource): void;
}
