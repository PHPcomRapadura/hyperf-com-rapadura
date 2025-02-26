<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Persistence\Converter;

use Serendipity\Infrastructure\Adapter\Serializing\Converter;

use function Serendipity\Type\Json\encode;
use function is_array;
use function is_string;

class FromArrayToDatabase implements Converter
{
    public function convert(mixed $value): ?string
    {
        if (is_string($value)) {
            return $value;
        }
        if (! is_array($value)) {
            return null;
        }
        return encode($value);
    }
}
