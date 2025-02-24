<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Exception;
use Throwable;

final class GeneratingException extends Exception
{
    public function __construct(
        public readonly string $type,
        Throwable $previous,
    ) {
        parent::__construct(
            message: sprintf('Error generating "%s": "%s"', $type, $previous->getMessage()),
            previous: $previous
        );
    }
}
