<?php

declare(strict_types=1);

namespace Backbone\Domain\Support;

readonly class Value
{
    public function __construct(public mixed $content)
    {
    }
}
