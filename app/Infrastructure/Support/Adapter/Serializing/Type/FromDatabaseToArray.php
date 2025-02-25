<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing\Type;

use App\Infrastructure\Support\Adapter\Mapping\Converter;

use function Util\Type\Json\decode;

class FromDatabaseToArray implements Converter
{
    public function convert(bool|int|string|array|null $value): ?array
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
