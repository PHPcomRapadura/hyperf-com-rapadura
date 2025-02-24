<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Persistence;

use App\Domain\Exception\GeneratingException;
use DateTimeImmutable;
use DateTimeInterface;
use Throwable;
use Visus\Cuid2\Cuid2;

readonly class Generator
{
    public function __construct(public int $length = 10)
    {
    }

    /**
     * @throws GeneratingException
     */
    public function id(): string
    {
        try {
            return (new Cuid2($this->length))->toString();
        } catch (Throwable $exception) {
            throw new GeneratingException('id', $exception);
        }
    }

    public function now(): string
    {
        return (new DateTimeImmutable())->format(DateTimeInterface::ATOM);
    }
}
