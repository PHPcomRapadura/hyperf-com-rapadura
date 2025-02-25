<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Relational;

use App\Infrastructure\Repository\Relational\Converter\FromArrayToDatabase;
use App\Infrastructure\Repository\Relational\Converter\FromDatetimeToDatabase;
use App\Infrastructure\Support\Adapter\Serializing\Deserializer;
use App\Infrastructure\Support\Adapter\Serializing\DeserializerFactory;
use DateTime;
use DateTimeImmutable;

class RelationalDeserializerFactory extends DeserializerFactory
{
    /**
     * @template T of object
     * @param class-string<T> $type
     * @return Deserializer<T>
     */
    public function make(string $type): Deserializer
    {
        return new Deserializer(type: $type, converters: [
            'array' => new FromArrayToDatabase(),
            DateTime::class => new FromDatetimeToDatabase(),
            DateTimeImmutable::class => new FromDatetimeToDatabase(),
        ]);
    }
}
