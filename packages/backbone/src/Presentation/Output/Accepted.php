<?php

declare(strict_types=1);

namespace Backbone\Presentation\Output;

class Accepted extends Output
{
    public function __construct(int|string $token)
    {
        parent::__construct(content: ['token' => $token]);
    }
}
