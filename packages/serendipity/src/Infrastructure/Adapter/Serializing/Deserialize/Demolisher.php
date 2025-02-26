<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Adapter\Serializing\Deserialize;

use Serendipity\Domain\Support\Outputable;
use Serendipity\Infrastructure\Adapter\Serializing\Deserialize\Resolve\ConverterChain;
use Serendipity\Infrastructure\Adapter\Serializing\Deserialize\Resolve\DependencyChain;
use Serendipity\Infrastructure\Adapter\Serializing\Deserialize\Resolve\DoNothingChain;
use Serendipity\Infrastructure\Adapter\Serializing\Serialize\Engine;

use function get_object_vars;

class Demolisher extends Engine
{
    /**
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

            $data[$name] = $resolved->content;
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
