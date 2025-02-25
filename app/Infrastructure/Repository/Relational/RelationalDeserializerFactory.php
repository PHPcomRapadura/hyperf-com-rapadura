<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Relational;

use App\Infrastructure\Repository\Relational\Converter\FromArrayToDatabase;
use App\Infrastructure\Repository\Relational\Converter\FromDatetimeToDatabase;
use App\Infrastructure\Support\Adapter\Serializing\DeserializerFactory;
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
