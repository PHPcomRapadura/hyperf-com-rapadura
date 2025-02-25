<?php

declare(strict_types=1);

namespace App\Domain\Exception\Mapping;

enum NotResolvedType
{
    case INVALID;
    case REQUIRED;
}
