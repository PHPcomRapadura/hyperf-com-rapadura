<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Relational\Converter;

use App\Infrastructure\Support\Adapter\Serializing\Converter;

use function Util\Type\Json\decode;

class FromDatabaseToArray implements Converter
{
    public function convert(mixed $value): ?array
    {
        if (is_array($value)) {
            return $value;
        }
        if (! is_string($value)) {
            return null;
        }
        return decode($value);
    }
}
