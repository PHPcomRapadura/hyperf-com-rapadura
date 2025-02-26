<?php

declare(strict_types=1);

namespace Serendipity\Domain\Exception\Mapping;

enum NotResolvedType
{
    case INVALID;
    case REQUIRED;
}
