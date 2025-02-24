<?php

declare(strict_types=1);

namespace App\Domain\Contract;

use App\Domain\Support\Values;

interface Result
{
    public function properties(): Values;

    public function content(): ?Values;
}
