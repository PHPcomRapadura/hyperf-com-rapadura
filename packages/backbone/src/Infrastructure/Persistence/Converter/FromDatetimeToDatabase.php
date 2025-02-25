<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Persistence\Converter;

use Backbone\Infrastructure\Adapter\Serializing\Converter;
use DateTimeInterface;

use function is_string;

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
