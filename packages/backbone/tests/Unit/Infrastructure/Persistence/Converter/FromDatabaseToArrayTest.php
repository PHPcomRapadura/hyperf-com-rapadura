<?php

declare(strict_types=1);

namespace Backbone\Test\Unit\Infrastructure\Persistence\Converter;

use Backbone\Infrastructure\Persistence\Converter\FromDatabaseToArray;
use Tests\Support\TestCase;

class FromDatabaseToArrayTest extends TestCase
{
    final public function testConvertStringToArray(): void
    {
        $converter = new FromDatabaseToArray();
        $string = '{"key":"value"}';
        $result = $converter->convert($string);

        $this->assertIsArray($result);
        $this->assertEquals(['key' => 'value'], $result);
    }

    final public function testConvertArrayToArray(): void
    {
        $converter = new FromDatabaseToArray();
        $array = ['key' => 'value'];
        $result = $converter->convert($array);

        $this->assertIsArray($result);
        $this->assertEquals($array, $result);
    }

    final public function testConvertInvalidTypeToNull(): void
    {
        $converter = new FromDatabaseToArray();
        $invalidValue = 123;
        $result = $converter->convert($invalidValue);

        $this->assertNull($result);
    }
}
