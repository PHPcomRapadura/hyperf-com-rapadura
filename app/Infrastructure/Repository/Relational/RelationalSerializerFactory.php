<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Relational;

use App\Infrastructure\Repository\Relational\Converter\FromDatabaseToArray;
use App\Infrastructure\Support\Adapter\Serializing\Serializer;
use App\Infrastructure\Support\Adapter\Serializing\SerializerFactory;

class RelationalSerializerFactory extends SerializerFactory
{
    /**
     * @template T of object
     * @param class-string<T> $type
     * @return Serializer<T>
     */
    public function make(string $type): Serializer
    {
        return new Serializer(type: $type, converters: ['array' => new FromDatabaseToArray()]);
    }
}
