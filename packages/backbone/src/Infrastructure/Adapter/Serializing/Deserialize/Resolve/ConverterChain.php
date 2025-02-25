<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Adapter\Serializing\Deserialize\Resolve;

use Backbone\Domain\Support\Value;
use Backbone\Infrastructure\Adapter\Serializing\Deserialize\Chain;

use function gettype;
use function Backbone\Type\Cast\toString;

class ConverterChain extends Chain
{
    public function resolve(mixed $value): Value
    {
        $type = $this->extractType($value);
        $conversor = $this->conversor($type);
        if ($conversor === null) {
            return parent::resolve($value);
        }
        return new Value($conversor->convert($value));
    }

    private function extractType(mixed $value): string
    {
        $type = gettype($value);
        $type = match ($type) {
            'double' => 'float',
            'integer' => 'int',
            'boolean' => 'bool',
            default => $type,
        };
        if ($type === 'object' && is_object($value)) {
            $type = $value::class;
        }
        return toString($type);
    }
}
