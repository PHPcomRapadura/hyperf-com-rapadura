<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Support\Adapter\Serializing\Deserialize\Resolve;

use App\Infrastructure\Support\Adapter\Serializing\Converter;
use App\Infrastructure\Support\Adapter\Serializing\Deserialize\Resolve\ConverterChain;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

use function Util\Type\Json\encode;

class ConverterChainTest extends TestCase
{
    #[TestWith(['string'])]
    #[TestWith([10])]
    #[TestWith([10.5])]
    #[TestWith([true])]
    #[TestWith([null])]
    #[TestWith([new \stdClass()])]
    final public function testResolveWithoutConverter(mixed $value): void
    {
        $chain = new ConverterChain();
        $result = $chain->resolve($value);

        $this->assertSame($value, $result->value);
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

        $this->assertEquals('{"key":"value"}', $result->value);
    }
}
