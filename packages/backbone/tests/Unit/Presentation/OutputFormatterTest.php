<?php

declare(strict_types=1);

namespace BackboneTest\Unit\Presentation;

use Backbone\Presentation\OutputFormatter;
use Tests\Support\TestCase;

class OutputFormatterTest extends TestCase
{
    use OutputFormatter;

    public function testShouldReturnSuccessPayload(): void
    {
        $statusCode = 200;
        $body = ['key' => 'value'];

        $result = $this->toPayload($statusCode, $body);

        $expected = json_encode([
            'status' => 'success',
            'data' => $body,
        ], JSON_THROW_ON_ERROR);

        $this->assertEquals($expected, $result);
    }

    public function testShouldReturnFailPayload(): void
    {
        $statusCode = 400;
        $body = ['error' => 'Invalid request'];

        $result = $this->toPayload($statusCode, $body);

        $expected = json_encode([
            'status' => 'fail',
            'data' => $body,
        ], JSON_THROW_ON_ERROR);

        $this->assertEquals($expected, $result);
    }

    public function testShouldReturnErrorPayload(): void
    {
        $statusCode = 500;
        $body = ['error' => 'Server error'];

        $result = $this->toPayload($statusCode, $body);

        $expected = json_encode([
            'status' => 'error',
            'message' => $body,
            'code' => $statusCode,
        ], JSON_THROW_ON_ERROR);

        $this->assertEquals($expected, $result);
    }

    public function testShouldHandleJsonException(): void
    {
        $statusCode = 200;
        $body = ["\xB1\x31"];

        $result = $this->toPayload($statusCode, $body);

        $this->assertStringContainsString('"status": "error"', $result);
        $this->assertStringContainsString('"message":', $result);
        $this->assertStringContainsString('"code": 200', $result);
    }
}
