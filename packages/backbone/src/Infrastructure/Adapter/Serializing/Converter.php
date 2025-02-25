<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Adapter\Serializing;

interface Converter
{
    public function convert(mixed $value): mixed;
}
