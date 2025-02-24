<?php

declare(strict_types=1);

namespace App\Domain\Contract;

/**
 * @template T of object
 */
interface Deserializer
{
    /**
     * @param T $instance
     * @return array<string, mixed>
     */
    public function deserialize(mixed $instance): array;
}
