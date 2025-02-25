<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Persistence\Relational;

use Backbone\Infrastructure\Adapter\Serializing\SerializerFactory;
use Backbone\Infrastructure\Persistence\Converter\FromDatabaseToArray;

class RelationalSerializerFactory extends SerializerFactory
{
    protected function converters(): array
    {
        return ['array' => new FromDatabaseToArray()];
    }
}
