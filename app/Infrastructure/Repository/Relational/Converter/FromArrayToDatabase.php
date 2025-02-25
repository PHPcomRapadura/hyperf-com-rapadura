<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Relational\Converter;

use App\Infrastructure\Support\Adapter\Serializing\Converter;

use function Util\Type\Json\encode;

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
