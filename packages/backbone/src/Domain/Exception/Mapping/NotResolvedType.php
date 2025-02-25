<?php

declare(strict_types=1);

namespace Backbone\Domain\Exception\Mapping;

enum NotResolvedType
{
    case INVALID;
    case REQUIRED;
}
