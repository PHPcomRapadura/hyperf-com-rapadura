<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Adapter\Serializing;

use Serendipity\Domain\Contract\Serializer as Contract;
use Serendipity\Domain\Support\Values;
use Serendipity\Infrastructure\Adapter\Serializing\Serialize\Builder;
use Serendipity\Infrastructure\CaseConvention;

/**
 * @template T of object
 * @implements Contract<T>
 */
class Serializer extends Builder implements Contract
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
     * @return T
     */
    public function serialize(array $datum): mixed
    {
        return $this->build($this->type, Values::createFrom($datum));
    }
}
