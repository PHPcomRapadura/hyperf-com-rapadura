<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Adapter\Serializing\Serialize;

use Backbone\Domain\Support\Values;

readonly class Context
{
    public function __construct(
        public string $class,
        public Values $values,
    ) {
    }
}
