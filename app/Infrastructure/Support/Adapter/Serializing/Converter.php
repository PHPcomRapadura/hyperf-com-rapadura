<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing;

interface Converter
{
    public function convert(mixed $value): mixed;
}
