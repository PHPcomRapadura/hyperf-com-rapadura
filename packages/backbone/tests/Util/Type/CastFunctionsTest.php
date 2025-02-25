<?php

declare(strict_types=1);

namespace BackboneTest\Util\Type;

use PHPUnit\Framework\TestCase;

use function Backbone\Type\Cast\toArray;
use function Backbone\Type\Cast\toBool;
use function Backbone\Type\Cast\toInt;
use function Backbone\Type\Cast\toString;

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
