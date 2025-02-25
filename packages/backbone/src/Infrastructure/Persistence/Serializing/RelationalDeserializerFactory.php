<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Persistence\Relational;

use Backbone\Infrastructure\Adapter\Serializing\DeserializerFactory;
use Backbone\Infrastructure\Persistence\Converter\FromArrayToDatabase;
use Backbone\Infrastructure\Persistence\Converter\FromDatetimeToDatabase;
use DateTime;
use DateTimeImmutable;

class RelationalDeserializerFactory extends DeserializerFactory
{
    protected function converters(): array
    {
        return [
            'array' => new FromArrayToDatabase(),
            DateTime::class => new FromDatetimeToDatabase(),
            DateTimeImmutable::class => new FromDatetimeToDatabase(),
        ];
    }
}
