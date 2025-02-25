<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Adapter\Serializing\Serialize\Resolve;

use App\Domain\Exception\Mapping\NotResolved;
use App\Domain\Support\Value;

class Consolidator
{
    /**
     * @var array mixed[]
     */
    private array $args = [];

    /**
     * @var NotResolved[]
     */
    private array $errors = [];

    public function consolidate(Value $resolved): void
    {
        if ($resolved->value instanceof NotResolved) {
            $this->errors[] = $resolved->value;
            return;
        }
        $this->args[] = $resolved->value;
    }

    /**
     * @return array mixed[]
     */
    public function args(): array
    {
        return $this->args;
    }

    /**
     * @return NotResolved[]
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
