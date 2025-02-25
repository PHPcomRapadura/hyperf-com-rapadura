<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing;

use App\Infrastructure\Support\Adapter\Serializing\Type\FromDatabaseToArray;

class SerializerFactory
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
