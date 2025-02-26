<?php

declare(strict_types=1);

namespace Serendipity\Domain\Contract;

use Serendipity\Domain\Support\Values;

interface Result
{
    public function properties(): Values;

    public function content(): ?Values;
}
