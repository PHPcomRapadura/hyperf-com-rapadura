<?php

declare(strict_types=1);

namespace Backbone\Domain\Exception\Mapping;

final readonly class NotResolved
{
    public function __construct(
        public NotResolvedType $type,
        public string $field = '',
        public mixed $value = null,
    ) {
    }

    public function message(): string
    {
        return match ($this->type) {
            NotResolvedType::REQUIRED => sprintf(
                "The value for '%s' is required and was not provided.",
                $this->field
            ),
            NotResolvedType::INVALID => sprintf(
                "The value for '%s' is not of the expected type.",
                $this->field
            ),
        };
    }
}
