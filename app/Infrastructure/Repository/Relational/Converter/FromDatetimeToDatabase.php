<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Relational\Converter;

use App\Infrastructure\Support\Adapter\Serializing\Converter;
use DateTimeInterface;

class FromDatetimeToDatabase implements Converter
{
    public function convert(mixed $value): ?string
    {
        if (is_string($value)) {
            return $value;
        }
        if ($value instanceof DateTimeInterface) {
            return $value->format(DateTimeInterface::ATOM);
        }
        return null;
    }
}
