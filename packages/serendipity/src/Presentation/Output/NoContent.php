<?php

declare(strict_types=1);

namespace Serendipity\Presentation\Output;

final class NoContent extends Output
{
    public function __construct(array $properties = [])
    {
        parent::__construct($properties, null);
    }
}
