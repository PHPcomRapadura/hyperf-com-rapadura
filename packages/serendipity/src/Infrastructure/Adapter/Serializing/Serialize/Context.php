<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Adapter\Serializing\Serialize;

use Serendipity\Domain\Support\Values;

readonly class Context
{
    public function __construct(
        public string $class,
        public Values $values,
    ) {
    }
}
