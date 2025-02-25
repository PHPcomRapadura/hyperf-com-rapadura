<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing\Serialize;

interface Converter
{
    public function convert(int|string|bool|null $value): mixed;
}
