<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing;

use App\Domain\Contract\Deserializer as Contract;
use App\Domain\Support\Outputable;
use InvalidArgumentException;
use JsonException;

/**
 * @template T of object
 * @implements Contract<T>
 */
class Deserializer implements Contract
{
    /**
     * @param class-string<T> $type
     */
    public function __construct(private readonly string $type)
    {
    }

    /**
     * @param T $instance
     * @return array<string, mixed>
     * @throws JsonException
     */
    public function deserialize(mixed $instance): array
    {
        if (is_object($instance) && $instance::class !== $this->type) {
            throw new InvalidArgumentException('Invalid instance type');
        }
        if ($instance instanceof Outputable) {
            return $instance->jsonSerialize();
        }
        /** @phpstan-ignore return.type */
        return json_decode(json_encode($instance, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);
    }
}
