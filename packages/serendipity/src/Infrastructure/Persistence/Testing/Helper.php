<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Persistence\Testing;

use Serendipity\Domain\Support\Values;

interface Helper
{
    public function truncate(string $resource): void;

    public function seed(string $type, string $resource, array $override = []): Values;

    public function assertHas(string $resource, array $filters): void;

    public function assertHasNot(string $resource, array $filters): void;

    public function assertHasCount(int $expected, string $resource, array $filters): void;

    public function assertIsEmpty(string $resource): void;
}
