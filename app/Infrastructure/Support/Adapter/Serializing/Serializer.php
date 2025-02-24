<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing;

use App\Domain\Contract\Serializer as Contract;
use App\Domain\Support\Values;
use App\Infrastructure\Support\Adapter\Mapping\Mapper;
use App\Infrastructure\Support\CaseConvention;

/**
 * @template T of object
 * @implements Contract<T>
 */
class Serializer extends Mapper implements Contract
{
    /**
     * @param class-string<T> $type
     */
    public function __construct(
        private readonly string $type,
        CaseConvention $case = CaseConvention::SNAKE
    ) {
        parent::__construct($case);
    }

    /**
     * @param array $datum
     * @return T
     */
    public function serialize(array $datum): mixed
    {
        return $this->map($this->type, Values::createFrom($datum));
    }
}
