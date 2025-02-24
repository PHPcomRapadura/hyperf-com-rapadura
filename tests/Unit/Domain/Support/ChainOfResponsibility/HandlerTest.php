<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Support\ChainOfResponsibility;

use App\Domain\Support\Value;
use Tests\TestCase;

class HandlerTest extends TestCase
{
    final public function testShouldResolveTheChainOne(): void
    {
        $one = new HandlerTestMockChainOne();
        $two = new HandlerTestMockChainTwo();
        $value = $one
            ->then($two)
            ->resolve(new Value(1));

        $this->assertEquals(1, $value->value);
    }

    final public function testShouldResolveTheChainTwo(): void
    {
        $value = (new HandlerTestMockChainTwo())
            ->then(new HandlerTestMockChainOne())
            ->resolve(new Value(2));

        $this->assertEquals(2, $value->value);
    }

    final public function testShouldNotResolveTheChain(): void
    {
        $value = (new HandlerTestMockChainTwo())
            ->then(new HandlerTestMockChainOne())
            ->resolve(new Value(3));

        $this->assertNull($value);
    }
}
