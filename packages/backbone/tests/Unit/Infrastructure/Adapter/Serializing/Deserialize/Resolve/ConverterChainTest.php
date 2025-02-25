<?php

declare(strict_types=1);

namespace BackboneTest\Unit\Infrastructure\Adapter\Serializing\Deserialize\Resolve;

use Backbone\Infrastructure\Adapter\Serializing\Converter;
use Backbone\Infrastructure\Adapter\Serializing\Deserialize\Resolve\ConverterChain;
use Backbone\Infrastructure\Testing\TestCase;
use PHPUnit\Framework\Attributes\TestWith;
use stdClass;

use function Backbone\Type\Json\encode;

/**
 * @internal
 * @coversNothing
 */
class ConverterChainTest extends TestCase
{
    #[TestWith(['string'])]
    #[TestWith([10])]
    #[TestWith([10.5])]
    #[TestWith([true])]
    #[TestWith([null])]
    #[TestWith([new stdClass()])]
    final public function testResolveWithoutConverter(mixed $value): void
    {
        $chain = new ConverterChain();
        $result = $chain->resolve($value);

        $this->assertSame($value, $result->content);
    }

    final public function testResolveWithArrayValue(): void
    {
        $converter = new class implements Converter {
            public function convert(mixed $value): ?string
            {
                return encode($value);
            }
        };
        $chain = new ConverterChain(converters: ['array' => $converter]);
        $value = ['key' => 'value'];
        $result = $chain->resolve($value);

        $this->assertEquals('{"key":"value"}', $result->content);
    }
}
