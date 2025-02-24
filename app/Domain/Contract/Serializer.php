<?php

declare(strict_types=1);

namespace App\Domain\Contract;

/**
 * @template T of object
 */
interface Serializer
{
    /**
     * @param array<string, mixed> $datum
     * @return T
     */
    public function serialize(array $datum): mixed;
}
