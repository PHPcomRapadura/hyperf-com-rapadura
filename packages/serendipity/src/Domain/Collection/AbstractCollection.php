<?php

declare(strict_types=1);

namespace Serendipity\Domain\Collection;

use Serendipity\Domain\Support\Outputable;
use Closure;
use Countable;
use Iterator;

/**
 * @template T
 * @template-implements Iterator<T>
 */
abstract class AbstractCollection extends Outputable implements Iterator, Countable
{
    private int $cursor = 0;

    public function __construct(protected array $data)
    {
    }

    final public function rewind(): void
    {
        $this->cursor = 0;
    }

    final public function key(): int
    {
        return $this->cursor;
    }

    final public function next(): void
    {
        ++$this->cursor;
    }

    final public function valid(): bool
    {
        return isset($this->data[$this->cursor]);
    }

    final public function count(): int
    {
        return count($this->data);
    }

    final public function all(): array
    {
        return $this->data;
    }

    final public function map(Closure $callback): array
    {
        return array_map($callback, $this->data());
    }

    final protected function data(): array
    {
        return $this->data;
    }

    final protected function datum(): mixed
    {
        return $this->data[$this->cursor] ?? null;
    }
}
