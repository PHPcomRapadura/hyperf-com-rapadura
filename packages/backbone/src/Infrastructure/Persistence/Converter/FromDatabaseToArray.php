<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Persistence\Converter;

use Backbone\Infrastructure\Adapter\Serializing\Converter;

use function Backbone\Type\Json\decode;

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
