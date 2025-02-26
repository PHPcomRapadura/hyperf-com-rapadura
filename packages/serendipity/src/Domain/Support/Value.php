<?php

declare(strict_types=1);

namespace Serendipity\Domain\Support;

readonly class Value
{
    public function __construct(public mixed $content)
    {
    }
}
