<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing;

class SerializerFactory
{
    /**
     * @template T of object
     * @param class-string<T> $type
     * @return Serializer<T>
     */
    public function make(string $type): Serializer
    {
        return new Serializer(type: $type, converters: $this->converters());
    }

    protected function converters(): array
    {
        return [];
    }
}
