<?php

declare(strict_types=1);

namespace Serendipity\Domain\Support;

use InvalidArgumentException;

use function array_key_exists;
use function array_map;
use function array_merge;
use function is_array;
use function is_object;
use function is_string;

final readonly class Values
{
    /**
     * @var array<string, mixed>
     */
    private array $data;

    public function __construct(mixed $values = [])
    {
        if (! is_array($values)) {
            throw new InvalidArgumentException('Values must be an array.');
        }
        $data = [];
        foreach ($values as $key => $value) {
            if (! is_string($key)) {
                throw new InvalidArgumentException('All keys must be strings.');
            }
            $data[$key] = $value;
        }
        $this->data = $data;
    }

    public static function createFrom(mixed $values): self
    {
        return new self($values);
    }

    public function get(string $field, mixed $default = null): mixed
    {
        return $this->data[$field] ?? $default;
    }

    public function with(string $field, mixed $value): self
    {
        return new self(array_merge($this->toArray(), [$field => $value]));
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_map(fn ($value) => is_object($value) ? clone $value : $value, $this->data);
    }

    public function along(array $values): self
    {
        return new self(array_merge($this->toArray(), $values));
    }

    public function has(string $field): bool
    {
        return array_key_exists($field, $this->data);
    }
}
