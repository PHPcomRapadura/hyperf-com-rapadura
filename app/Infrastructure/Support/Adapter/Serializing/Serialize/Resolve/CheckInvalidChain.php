<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing\Serialize\Resolve;

use App\Domain\Exception\Mapping\NotResolved;
use App\Domain\Exception\Mapping\NotResolvedType;
use App\Domain\Support\Value;
use App\Domain\Support\Values;
use ReflectionParameter;

use function gettype;

class CheckInvalidChain extends Chain
{
    public function resolve(ReflectionParameter $parameter, Values $values): Value
    {
        $type = $parameter->getType();
        $name = $this->normalize($parameter);

        $value = $values->get($name);
        if ($type === null) {
            return new Value($value);
        }

        $types = $this->normalizeType($type);
        foreach ($types as $type) {
            if ($this->isValidType($value, $type)) {
                return new Value($value);
            }
        }
        return new Value(new NotResolved(NotResolvedType::INVALID, $name, $value));
    }

    private function isValidType(mixed $value, string $expected): bool
    {
        $type = gettype($value);
        $actual = match ($type) {
            'double' => 'float',
            'integer' => 'int',
            'boolean' => 'bool',
            default => $type,
        };

        return $actual === $expected || ($type === 'object' && $value instanceof $expected);
    }
}
