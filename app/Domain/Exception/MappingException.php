<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use App\Domain\Exception\Mapping\NotResolved;
use App\Domain\Support\Values;
use InvalidArgumentException;
use Throwable;

final class MappingException extends InvalidArgumentException
{
    /**
     * @param Values $values
     * @param array<NotResolved> $unresolved
     * @param Throwable|null $error
     */
    public function __construct(
        public readonly Values $values,
        private readonly array $unresolved = [],
        ?Throwable $error = null,
    ) {
        parent::__construct(
            message: $this->parse($unresolved, $error),
            previous: $error,
        );
    }

    public function getUnresolved(): array
    {
        return $this->unresolved;
    }

    private function parse(array $errors, ?Throwable $error = null): string
    {
        if ($error !== null) {
            return $error->getMessage();
        }
        return sprintf(
            'Mapping failed with %d error(s). The errors are: "%s"',
            count($errors),
            implode('", "', $this->merge($errors)),
        );
    }

    /**
     * @param array<NotResolved> $errors
     * @return array|string[]
     */
    private function merge(array $errors): array
    {
        return array_map(fn (NotResolved $error) => $error->message(), $errors);
    }
}
