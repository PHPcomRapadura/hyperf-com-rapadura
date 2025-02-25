<?php

declare(strict_types=1);

namespace BackboneTest\Unit\Infrastructure\Adapter\Serializing\Deserialize\Resolve;

use Backbone\Infrastructure\Adapter\Serializing\Deserialize\Resolve\DependencyChain;
use Backbone\Infrastructure\Testing\TestCase;
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
