<?php

declare(strict_types=1);

namespace Backbone\Type\Cast;

if (! function_exists('toArray')) {
    /**
     * @template T of array-key
     * @template U
     * @param array<T, U> $default
     * @return array<T, U>
     */
    function toArray(mixed $value, array $default = []): array
    {
        return is_array($value) ? $value : $default;
    }
}

if (! function_exists('toString')) {
    function toString(mixed $value, string $default = ''): string
    {
        return is_string($value) ? $value : $default;
    }
}

if (! function_exists('toInt')) {
    function toInt(mixed $value, int $default = 0): int
    {
        return is_int($value) ? $value : $default;
    }
}

if (! function_exists('toFloat')) {
    function toFloat(mixed $value, float $default = 0.0): float
    {
        return is_float($value) ? $value : $default;
    }
}

if (! function_exists('toBool')) {
    function toBool(mixed $value, bool $default = false): bool
    {
        return is_bool($value) ? $value : $default;
    }
}

namespace Backbone\Type\Array;

if (! function_exists('extractArray')) {
    /**
     * @template T
     * @template U
     * @param array<string, array<T, U>> $array
     * @param array<T, U> $default
     * @return array<T, U>
     */
    function extractArray(array $array, string $property, array $default = []): array
    {
        $details = $array[$property] ?? null;
        if (! is_array($details)) {
            return $default;
        }
        return $details;
    }
}

if (! function_exists('extractString')) {
    /**
     * @param array<string, mixed> $array
     */
    function extractString(array $array, string $property, string $default = ''): string
    {
        $string = $array[$property] ?? $default;
        return is_string($string) ? $string : $default;
    }
}

if (! function_exists('extractInt')) {
    /**
     * @param array<string, mixed> $array
     */
    function extractInt(array $array, string $property, int $default = 0): int
    {
        $int = $array[$property] ?? $default;
        return is_int($int) ? $int : $default;
    }
}

if (! function_exists('extractBool')) {
    /**
     * @param array<string, mixed> $array
     */
    function extractBool(array $array, string $property, bool $default = false): bool
    {
        $bool = $array[$property] ?? $default;
        return is_bool($bool) ? $bool : $default;
    }
}

if (! function_exists('extractNumeric')) {
    /**
     * @param array<string, mixed> $array
     */
    function extractNumeric(array $array, string $property, float|int $default = 0): float
    {
        $numeric = $array[$property] ?? $default;
        return (float) (is_numeric($numeric) ? $numeric : $default);
    }
}

namespace Backbone\Type\String;

use function Backbone\Type\Cast\toString;

if (! function_exists('toSnakeCase')) {
    function toSnakeCase(string $string): string
    {
        $string = toString(preg_replace('/[A-Z]/', '_$0', $string));
        return strtolower(ltrim($string, '_'));
    }
}

namespace Backbone\Type\Json;

use JsonException;

use function Backbone\Type\Cast\toArray;
use function Backbone\Type\Cast\toString;

if (! function_exists('decode')) {
    function decode(string $json): ?array
    {
        try {
            return toArray(json_decode($json, true, 512, JSON_THROW_ON_ERROR));
        } catch (JsonException) {
            return null;
        }
    }
}

if (! function_exists('encode')) {
    function encode(array $data): ?string
    {
        try {
            return toString(json_encode($data, JSON_THROW_ON_ERROR));
        } catch (JsonException) {
            return null;
        }
    }
}
