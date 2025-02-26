<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Adapter\Serializing;

use Serendipity\Domain\Contract\Deserializer as Contract;
use Serendipity\Infrastructure\Adapter\Serializing\Deserialize\Demolisher;
use Serendipity\Infrastructure\CaseConvention;
use InvalidArgumentException;

use function is_object;

/**
 * @template T of object
 * @implements Contract<T>
 */
class Deserializer extends Demolisher implements Contract
{
    /**
     * @param class-string<T> $type
     */
    public function __construct(
        private readonly string $type,
        CaseConvention $case = CaseConvention::SNAKE,
        array $converters = [],
    ) {
        parent::__construct($case, $converters);
    }

    /**
     * @param T $instance
     * @return array<string, mixed>
     */
    public function deserialize(mixed $instance): array
    {
        if (is_object($instance) && $instance::class !== $this->type) {
            throw new InvalidArgumentException('Invalid instance type');
        }

        return $this->demolish($instance);
    }
}
