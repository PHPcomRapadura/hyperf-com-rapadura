<?php

declare(strict_types=1);

namespace Backbone\Presentation\Output;

class NotFound extends Output
{
    public function __construct(string $missing, string|int $what)
    {
        $properties = [
            'Missing' => sprintf('"%s" identified by "%s" not found', $missing, $what),
        ];
        parent::__construct($properties);
    }
}
