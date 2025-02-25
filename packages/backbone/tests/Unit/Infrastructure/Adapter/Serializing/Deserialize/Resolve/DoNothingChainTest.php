<?php

declare(strict_types=1);

namespace BackboneTest\Unit\Infrastructure\Adapter\Serializing\Deserialize\Resolve;

use Backbone\Infrastructure\Adapter\Serializing\Deserialize\Resolve\DoNothingChain;
use Backbone\Infrastructure\Testing\TestCase;

class DoNothingChainTest extends TestCase
{
    final public function testResolveValue(): void
    {
        $chain = new DoNothingChain();
        $value = 'test';
        $result = $chain->resolve($value);

        $this->assertEquals('test', $result->content);
    }
}
