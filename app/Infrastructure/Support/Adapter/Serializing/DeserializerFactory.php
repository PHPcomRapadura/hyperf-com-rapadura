<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing;

class DeserializerFactory
{
    /**
     * @template T of object
     * @param class-string<T> $type
     * @return Deserializer<T>
     */
    public function make(string $type): Deserializer
    {
        return new Deserializer(type: $type, converters: $this->converters());
    }

    protected function converters(): array
    {
        return [];
    }
}
