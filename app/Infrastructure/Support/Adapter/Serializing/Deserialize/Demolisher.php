<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing\Deserialize;

use App\Domain\Support\Outputable;
use App\Infrastructure\Support\Adapter\Serializing\Deserialize\Resolve\ConverterChain;
use App\Infrastructure\Support\Adapter\Serializing\Deserialize\Resolve\DependencyChain;
use App\Infrastructure\Support\Adapter\Serializing\Deserialize\Resolve\DoNothingChain;
use App\Infrastructure\Support\Adapter\Serializing\Serialize\Engine;

class Demolisher extends Engine
{
    /**
     * @param object $instance
     * @return array<string, mixed>
     */
    public function demolish(object $instance): array
    {
        $values = $this->extractValues($instance);
        $data = [];
        foreach ($values as $field => $value) {
            $name = $this->normalize($field);

            $resolved = (new DoNothingChain($this->case))
                ->then(new DependencyChain($this->case))
                ->then(new ConverterChain($this->case, $this->converters))
                ->resolve($value);

            $data[$name] = $resolved->value;
        }
        return $data;
    }

    public function extractValues(object $instance): array
    {
        if ($instance instanceof Outputable) {
            return $instance->content()?->toArray() ?? [];
        }
        return get_object_vars($instance);
    }
}
