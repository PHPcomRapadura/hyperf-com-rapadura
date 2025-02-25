<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Persistence\Converter;

use Backbone\Infrastructure\Adapter\Serializing\Converter;

use function Backbone\Type\Json\encode;
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
