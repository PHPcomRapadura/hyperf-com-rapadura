<?php

declare(strict_types=1);

namespace BackboneTest\Unit\Infrastructure\Http\Exception\Handler;

use Backbone\Infrastructure\Http\Exception\Handler\AppExceptionHandler;
use Exception;
use Hyperf\HttpMessage\Server\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Backbone\Infrastructure\Testing\TestCase;

class AppExceptionHandlerTest extends TestCase
{
    public function testHandleShouldLogErrorAndReturnFormattedResponseWith500Code(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())
            ->method('error')
            ->with(
                $this->stringContains('[app.error]'),
                $this->arrayHasKey('message')
            );

        $handler = new AppExceptionHandler($logger);
        $response = new Response();

        $throwable = new Exception('Test Exception', 500);

        $result = $handler->handle($throwable, $response);

        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertEquals(500, $result->getStatusCode());
        $this->assertJson((string) $result->getBody());
    }

    public function testHandleShouldLogErrorAndReturnFormattedResponseWith404Code(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())
            ->method('error')
            ->with(
                $this->stringContains('[app.error]'),
                $this->arrayHasKey('message')
            );

        $handler = new AppExceptionHandler($logger);
        $response = new Response();

        $throwable = new Exception('Test Exception', 404);

        $result = $handler->handle($throwable, $response);

        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertEquals(404, $result->getStatusCode());
        $this->assertJson((string) $result->getBody());
    }

    public function testIsValidShouldAlwaysReturnIfExceptionIsNotIgnored(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $handler = new AppExceptionHandler($logger);

        $throwable = new Exception('Test Exception');

        $this->assertTrue($handler->isValid($throwable));
    }
}
