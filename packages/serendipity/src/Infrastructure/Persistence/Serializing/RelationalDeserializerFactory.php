<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Persistence\Serializing;

use Serendipity\Infrastructure\Adapter\Serializing\DeserializerFactory;
use Serendipity\Infrastructure\Persistence\Converter\FromArrayToDatabase;
use Serendipity\Infrastructure\Persistence\Converter\FromDatetimeToDatabase;
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
