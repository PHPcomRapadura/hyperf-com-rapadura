<?php

declare(strict_types=1);

namespace Backbone\Presentation\Output;

class Accepted extends Output
{
    public function __construct(string|int $token)
    {
        parent::__construct(content: ['token' => $token]);
    }
}
