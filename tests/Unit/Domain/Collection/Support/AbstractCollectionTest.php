<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Collection\Support;

use App\Domain\Collection\Support\AbstractCollection;
use Tests\TestCase;

class AbstractCollectionTest extends TestCase
{
    final public function testShouldRewind(): void
    {
        $collection = new class([1, 2, 3]) extends AbstractCollection {
            public function current(): mixed
            {
                return $this->datum();
            }
        };

        $collection->next();
        $collection->rewind();

        $this->assertEquals(0, $collection->key());
        $this->assertEquals(1, $collection->current());
    }

    final public function testShouldReturnKey(): void
    {
        $collection = new class([1, 2, 3]) extends AbstractCollection {
            public function current(): mixed
            {
                return $this->datum();
            }
        };

        $collection->next();

        $this->assertEquals(1, $collection->key());
    }

    final public function testShouldReturnNext(): void
    {
        $collection = new class([1, 2, 3]) extends AbstractCollection {
            public function current(): mixed
            {
                return $this->datum();
            }
        };

        $collection->next();

        $this->assertEquals(1, $collection->key());
    }

    final public function testShouldReturnValid(): void
    {
        $collection = new class([1, 2, 3]) extends AbstractCollection {
            public function current(): mixed
            {
                return $this->datum();
            }
        };

        $collection->next();

        $this->assertTrue($collection->valid());
    }

    final public function testShouldReturnCount(): void
    {
        $collection = new class([1, 2, 3]) extends AbstractCollection {
            public function current(): mixed
            {
                return $this->datum();
            }
        };

        $this->assertEquals(3, $collection->count());
    }

    final public function testShouldReturnRows(): void
    {
        $collection = new class([1, 2, 3]) extends AbstractCollection {
            public function current(): mixed
            {
                return $this->datum();
            }

            public function length(): int
            {
                return count($this->data());
            }
        };

        $this->assertEquals(3, $collection->length());
    }

    final public function testShouldReturnAll(): void
    {
        $collection = new class([1, 2, 3]) extends AbstractCollection {
            public function current(): mixed
            {
                return $this->datum();
            }
        };

        $this->assertEquals([1, 2, 3], $collection->all());
    }

    final public function testShouldReturnMap(): void
    {
        $collection = new class([1, 2, 3]) extends AbstractCollection {
            public function current(): mixed
            {
                return $this->datum();
            }
        };

        $result = $collection->map(fn ($item) => $item * 2);

        $this->assertEquals([2, 4, 6], $result);
    }
}
