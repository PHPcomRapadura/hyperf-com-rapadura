<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Relational\Converter;

use App\Infrastructure\Support\Adapter\Serializing\Converter;

use function Util\Type\Json\decode;

class FromDatabaseToArray implements Converter
{
    public function convert(mixed $value): ?array
    {
        if ($value === null) {
            return null;
        }
        if (is_array($value)) {
            return $value;
        }
        return decode($value);
    }
}
