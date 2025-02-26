<?php

declare(strict_types=1);

namespace Serendipity\Test\Unit\Infrastructure\Adapter\Serializing\Deserialize\Resolve;

use Serendipity\Infrastructure\Adapter\Serializing\Deserialize\Resolve\DependencyChain;
use Serendipity\Infrastructure\Testing\TestCase;
use stdClass;

/**
 * @internal
 * @coversNothing
 */
class DependencyChainTest extends TestCase
{
    final public function testResolveObject(): void
    {
        $chain = new DependencyChain();
        $object = new stdClass();
        $result = $chain->resolve($object);

        $this->assertIsArray($result->content);
    }

    final public function testResolveNonObject(): void
    {
        $chain = new DependencyChain();
        $value = 'test';
        $result = $chain->resolve($value);

        $this->assertEquals('test', $result->content);
    }
}
