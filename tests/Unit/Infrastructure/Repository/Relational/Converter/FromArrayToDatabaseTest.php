<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Repository\Relational\Converter;

use App\Infrastructure\Repository\Relational\Converter\FromArrayToDatabase;
use Tests\TestCase;

class FromArrayToDatabaseTest extends TestCase
{
    final public function testConvertArrayToString(): void
    {
        $converter = new FromArrayToDatabase();
        $array = ['key' => 'value'];
        $result = $converter->convert($array);

        $this->assertIsString($result);
        $this->assertEquals('{"key":"value"}', $result);
    }

    final public function testConvertStringToString(): void
    {
        $converter = new FromArrayToDatabase();
        $string = '{"key":"value"}';
        $result = $converter->convert($string);

        $this->assertIsString($result);
        $this->assertEquals($string, $result);
    }

    final public function testConvertInvalidTypeToNull(): void
    {
        $converter = new FromArrayToDatabase();
        $invalidValue = 123;
        $result = $converter->convert($invalidValue);

        $this->assertNull($result);
    }
}
