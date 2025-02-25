<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Relational;

use App\Infrastructure\Repository\Relational\Converter\FromDatabaseToArray;
use App\Infrastructure\Support\Adapter\Serializing\SerializerFactory;

class RelationalSerializerFactory extends SerializerFactory
{
    protected function converters(): array
    {
        return ['array' => new FromDatabaseToArray()];
    }
}
