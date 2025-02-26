<?php

declare(strict_types=1);

namespace Serendipity\Domain\Support;

use Serendipity\Domain\Contract\Result;
use Hyperf\Contract\Jsonable;
use JsonException;
use JsonSerializable;

use function Serendipity\Type\String\toSnakeCase;
use function get_object_vars;
use function json_encode;
use function sprintf;

abstract class Outputable implements Result, JsonSerializable, Jsonable
{
    final public function __toString(): string
    {
        try {
            return json_encode($this, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return sprintf('{"error": "%s"}', $e->getMessage());
        }
    }

    public function properties(): Values
    {
        return Values::createFrom([]);
    }

    final public function content(): ?Values
    {
        $values = $this->extract();
        if (empty($values)) {
            return null;
        }
        return Values::createFrom($values);
    }

    /**
     * @return array<string, mixed>
     */
    public function extract(): array
    {
        $properties = get_object_vars($this);
        $extracted = [];
        foreach ($properties as $key => $value) {
            $snakeCaseKey = toSnakeCase($key);
            $extracted[$snakeCaseKey] = $value;
        }
        return $extracted;
    }

    /**
     * @return array<string, mixed>
     */
    final public function jsonSerialize(): array
    {
        return $this->extract();
    }
}
