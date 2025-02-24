<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Presentation\Output;

final class Created extends Output
{
    public function __construct(string $id)
    {
        parent::__construct(content: ['id' => $id]);
    }
}
