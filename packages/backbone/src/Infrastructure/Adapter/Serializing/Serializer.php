<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Adapter\Serializing;

use Backbone\Domain\Contract\Serializer as Contract;
use Backbone\Domain\Support\Values;
use Backbone\Infrastructure\Adapter\Serializing\Serialize\Builder;
use Backbone\Infrastructure\CaseConvention;

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
     * @param array $datum
     * @return T
     */
    public function serialize(array $datum): mixed
    {
        return $this->build($this->type, Values::createFrom($datum));
    }
}
