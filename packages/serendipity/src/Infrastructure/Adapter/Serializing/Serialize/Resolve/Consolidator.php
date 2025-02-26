<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Adapter\Serializing\Serialize\Resolve;

use Serendipity\Domain\Exception\Mapping\NotResolved;
use Serendipity\Domain\Support\Value;

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
        if ($resolved->content instanceof NotResolved) {
            $this->errors[] = $resolved->content;
            return;
        }
        $this->args[] = $resolved->content;
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
