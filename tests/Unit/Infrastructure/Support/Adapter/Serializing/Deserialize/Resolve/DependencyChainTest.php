<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Support\Adapter\Serializing\Deserialize\Resolve;

use App\Infrastructure\Support\Adapter\Serializing\Deserialize\Resolve\DependencyChain;
use stdClass;
use Tests\Support\TestCase;

class DependencyChainTest extends TestCase
{
    final public function testResolveObject(): void
    {
        $chain = new DependencyChain();
        $object = new stdClass();
        $result = $chain->resolve($object);

        $this->assertIsArray($result->value);
    }

    final public function testResolveNonObject(): void
    {
        $chain = new DependencyChain();
        $value = 'test';
        $result = $chain->resolve($value);

        $this->assertEquals('test', $result->value);
    }
}
