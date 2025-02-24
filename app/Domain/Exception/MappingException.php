<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use App\Domain\Support\Values;
use InvalidArgumentException;

final class MappingException extends InvalidArgumentException
{
    /**
     * @param Values $values
     * @param array<MappingExceptionItem> $errors
     */
    public function __construct(
        public readonly Values $values,
        private readonly array $errors,
    ) {
        parent::__construct(
            sprintf(
                'Mapping failed with %d error(s). The errors are: "%s"',
                count($errors),
                implode('", "', $this->merge($errors)),
            )
        );
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array<MappingExceptionItem> $errors
     * @return array|string[]
     */
    private function merge(array $errors): array
    {
        return array_map(fn (MappingExceptionItem $error) => $error->message, $errors);
    }
}
