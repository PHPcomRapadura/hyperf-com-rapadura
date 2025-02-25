<?php

declare(strict_types=1);

namespace Backbone\Domain\Exception;

use Backbone\Domain\Exception\Mapping\NotResolved;
use Backbone\Domain\Support\Values;
use InvalidArgumentException;
use Throwable;

use function array_map;
use function count;
use function implode;
use function sprintf;

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

    /**
     * @param array<NotResolved> $notResolved
     * @param Throwable|null $error
     * @return string
     */
    private function parse(array $notResolved, ?Throwable $error = null): string
    {
        if ($error !== null) {
            return $error->getMessage();
        }
        return sprintf(
            'Mapping failed with %d error(s). The errors are: "%s"',
            count($notResolved),
            implode('", "', $this->merge($notResolved)),
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

    public function getUnresolved(): array
    {
        return $this->unresolved;
    }
}
