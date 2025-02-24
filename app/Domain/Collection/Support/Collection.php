<?php

declare(strict_types=1);

namespace App\Domain\Collection\Support;

use App\Domain\Contract\Serializer;
use DomainException;

/**
 * @template T
 * @extends AbstractCollection<T>
 */
abstract class Collection extends AbstractCollection
{
    final private function __construct(protected readonly Serializer $serializer)
    {
        parent::__construct([]);
    }

    /**
     * @param array<array<string, mixed>> $data
     * @param Serializer $serializer
     * @return static<T>
     */
    final public static function createFrom(array $data, Serializer $serializer): static
    {
        $collection = new static($serializer);
        foreach ($data as $datum) {
            if (is_array($datum)) {
                $collection->append($datum);
                continue;
            }
            $collection->push($datum);
        }
        return $collection;
    }

    /**
     * @param array<string, mixed> $datum
     * @return void
     */
    final protected function append(array $datum): void
    {
        $this->data[] = $this->serializer->serialize($datum);
    }

    final protected function push(mixed $datum): void
    {
        $this->data[] = $this->validate($datum);
    }

    abstract protected function validate(mixed $datum): mixed;

    protected function exception(string $type, mixed $datum): DomainException
    {
        $message = sprintf('Invalid type. Expected "%s", got "%s"', $type, get_debug_type($datum));
        return new DomainException($message);
    }
}
