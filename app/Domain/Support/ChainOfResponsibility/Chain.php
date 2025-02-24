<?php

declare(strict_types=1);

namespace App\Domain\Support\ChainOfResponsibility;

use App\Domain\Support\Value;

interface Chain
{
    public function then(Chain $chain): Chain;

    public function resolve(Value $value): ?Value;
}
