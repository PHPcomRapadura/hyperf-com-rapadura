<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Persistence\Converter;

use Serendipity\Infrastructure\Adapter\Serializing\Converter;

use function Serendipity\Type\Json\decode;
use function is_array;
use function is_string;

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
