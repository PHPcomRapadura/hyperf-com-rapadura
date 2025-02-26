<?php

declare(strict_types=1);

namespace Serendipity\Test\Integration\Type;

use PHPUnit\Framework\TestCase;

use function Serendipity\Type\Cast\toArray;
use function Serendipity\Type\Cast\toBool;
use function Serendipity\Type\Cast\toInt;
use function Serendipity\Type\Cast\toString;

/**
 * @internal
 * @coversNothing
 */
class CastFunctionsTest extends TestCase
{
    public function testToArrayReturnsArrayWhenValueIsArray(): void
    {
        $value = ['key' => 'value'];
        $result = toArray($value);
        $this->assertEquals($value, $result);
    }

    public function testToArrayReturnsDefaultWhenValueIsNotArray(): void
    {
        $value = 'not an array';
        $default = ['default'];
        $result = toArray($value, $default);
        $this->assertEquals($default, $result);
    }

    public function testToStringReturnsStringWhenValueIsString(): void
    {
        $value = 'string';
        $result = toString($value);
        $this->assertEquals($value, $result);
    }

    public function testToStringReturnsDefaultWhenValueIsNotString(): void
    {
        $value = 123;
        $default = 'default';
        $result = toString($value, $default);
        $this->assertEquals($default, $result);
    }

    public function testToIntReturnsIntWhenValueIsInt(): void
    {
        $value = 123;
        $result = toInt($value);
        $this->assertEquals($value, $result);
    }

    public function testToIntReturnsDefaultWhenValueIsNotInt(): void
    {
        $value = 'not an int';
        $default = 456;
        $result = toInt($value, $default);
        $this->assertEquals($default, $result);
    }

    public function testToBoolReturnsBoolWhenValueIsBool(): void
    {
        $value = true;
        $result = toBool($value);
        $this->assertEquals($value, $result);
    }

    public function testToBoolReturnsDefaultWhenValueIsNotBool(): void
    {
        $value = 'not a bool';
        $default = true;
        $result = toBool($value, $default);
        $this->assertEquals(true, $result);
    }
}
