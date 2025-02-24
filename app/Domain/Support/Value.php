<?php

declare(strict_types=1);

namespace App\Domain\Support;

readonly class Value
{
    public function __construct(public mixed $value)
    {
    }
}
