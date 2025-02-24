<?php

declare(strict_types=1);

namespace App\Domain\Exception;

final readonly class MappingExceptionItem
{
    public string $message;

    public function __construct(
        public string $kind,
        public mixed $value = null,
        public string $field = '',
        string $message = '',
    ) {
        $this->message = match ($kind) {
            'required' => sprintf("The value for '%s' is required and was not provided.", $field),
            'invalid' => sprintf("The value for '%s' is not of the expected type.", $field),
            default => $message,
        };
    }
}
