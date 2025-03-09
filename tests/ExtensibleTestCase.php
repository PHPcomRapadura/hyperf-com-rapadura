<?php

declare(strict_types=1);

namespace Tests;


use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class ExtensibleTestCase extends TestCase
{
    private array $callbacks = [];

    protected function tearDown(): void
    {
        gc_collect_cycles();

        foreach ($this->callbacks as $callback) {
            $callback();
        }
        parent::tearDown();
    }

    protected function registerTearDown(callable $callback): void
    {
        $this->callbacks[] = $callback;
    }
}
