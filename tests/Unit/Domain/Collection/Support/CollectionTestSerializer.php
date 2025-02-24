<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Collection\Support;

use App\Domain\Contract\Serializer;
use DomainException;

class CollectionTestSerializer implements Serializer
{
    public function serialize(array $datum): CollectionTestMockStub
    {
        if (! isset($datum['value'])) {
            throw new DomainException('Invalid data. Datum must have a "value" key');
        }
        return new CollectionTestMockStub($datum['value']);
    }
}
