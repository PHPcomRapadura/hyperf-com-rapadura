<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Persistence\Serializing;

use Serendipity\Infrastructure\Adapter\Serializing\SerializerFactory;
use Serendipity\Infrastructure\Persistence\Converter\FromDatabaseToArray;

class RelationalSerializerFactory extends SerializerFactory
{
    protected function converters(): array
    {
        return ['array' => new FromDatabaseToArray()];
    }
}
