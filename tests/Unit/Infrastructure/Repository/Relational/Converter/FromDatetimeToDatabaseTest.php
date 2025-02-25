<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Repository\Relational\Converter;

use App\Infrastructure\Repository\Relational\Converter\FromDatetimeToDatabase;
use DateTime;
use Tests\TestCase;

class FromDatetimeToDatabaseTest extends TestCase
{
    final public function testConvertDatetimeToString(): void
    {
        $converter = new FromDatetimeToDatabase();
        $datetime = new DateTime('2023-01-01T00:00:00+00:00');
        $result = $converter->convert($datetime);

        $this->assertIsString($result);
        $this->assertEquals('2023-01-01T00:00:00+00:00', $result);
    }

    final public function testConvertStringToString(): void
    {
        $converter = new FromDatetimeToDatabase();
        $string = '2023-01-01T00:00:00+00:00';
        $result = $converter->convert($string);

        $this->assertIsString($result);
        $this->assertEquals($string, $result);
    }

    final public function testConvertInvalidTypeToNull(): void
    {
        $converter = new FromDatetimeToDatabase();
        $invalidValue = 123;
        $result = $converter->convert($invalidValue);

        $this->assertNull($result);
    }
}
