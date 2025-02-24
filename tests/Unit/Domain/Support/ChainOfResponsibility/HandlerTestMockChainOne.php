<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Support\ChainOfResponsibility;

use App\Domain\Support\ChainOfResponsibility\Handler;
use App\Domain\Support\Value;

class HandlerTestMockChainOne extends Handler
{
    public function resolve(Value $value): ?Value
    {
        $resolved = parent::resolve($value);
        return $resolved ?? (($value->value === 1) ? $value : null);
    }
}
