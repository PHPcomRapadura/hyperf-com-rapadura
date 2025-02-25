<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing\Serialize;

use App\Domain\Support\Values;

readonly class Context
{
    public function __construct(
        public string $class,
        public Values $values,
    ) {
    }
}
