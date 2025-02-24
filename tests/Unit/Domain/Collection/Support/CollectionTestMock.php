<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Collection\Support;

use App\Domain\Collection\Support\Collection;

final class CollectionTestMock extends Collection
{
    public function current(): CollectionTestMockStub
    {
        return $this->validate($this->datum());
    }

    protected function validate(mixed $datum): CollectionTestMockStub
    {
        if ($datum instanceof CollectionTestMockStub) {
            return $datum;
        }
        throw $this->exception(CollectionTestMockStub::class, $datum);
    }
}
