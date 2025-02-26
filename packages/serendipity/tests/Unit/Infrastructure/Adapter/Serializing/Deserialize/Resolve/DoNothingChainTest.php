<?php

declare(strict_types=1);

namespace Serendipity\Test\Unit\Infrastructure\Adapter\Serializing\Deserialize\Resolve;

use Serendipity\Infrastructure\Adapter\Serializing\Deserialize\Resolve\DoNothingChain;
use Serendipity\Infrastructure\Testing\TestCase;

/**
 * @internal
 * @coversNothing
 */
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
