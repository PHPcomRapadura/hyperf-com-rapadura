<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Adapter\Serializing\Deserialize\Resolve;

use Serendipity\Domain\Support\Value;
use Serendipity\Infrastructure\Adapter\Serializing\Deserialize\Chain;

use function Serendipity\Type\Cast\toString;
use function gettype;
use function is_object;

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
