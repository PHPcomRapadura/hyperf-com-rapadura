<?php

declare(strict_types=1);

namespace Backbone\Presentation\Output;

final class Created extends Output
{
    public function __construct(string $id)
    {
        parent::__construct(content: ['id' => $id]);
    }
}
