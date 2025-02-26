<?php

declare(strict_types=1);

namespace Serendipity\Test\Unit\Infrastructure\Http\Exception\Handler;

use Serendipity\Infrastructure\Http\Exception\Handler\ValidationExceptionHandler;
use Serendipity\Infrastructure\Testing\TestCase;
use Hyperf\Contract\MessageBag;
use Hyperf\Contract\ValidatorInterface;
use Hyperf\HttpMessage\Server\Response;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @internal
 * @coversNothing
 */
class ValidationExceptionHandlerTest extends TestCase
{
    public function testHandleShouldReturnValidationErrors(): void
    {
        $handler = new ValidationExceptionHandler();
        $response = new Response();

        $messageBag = $this->createMock(MessageBag::class);
        $messageBag->method('getMessages')->willReturn(['field' => ['Validation error']]);

        $validator = $this->createMock(ValidatorInterface::class);
        $validator->method('errors')->willReturn($messageBag);

        $throwable = new ValidationException($validator);

        $result = $handler->handle($throwable, $response);

        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertEquals(422, $result->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['field' => ['Validation error']], JSON_THROW_ON_ERROR),
            (string) $result->getBody()
        );
    }

    public function testHandleShouldReturnJsonErrorOnJsonException(): void
    {
        $handler = new ValidationExceptionHandler();
        $response = new Response();

        $messageBag = $this->createMock(MessageBag::class);
        $messageBag->method('getMessages')->willReturn(["\xB1\x31"]);

        $validator = $this->createMock(ValidatorInterface::class);
        $validator->method('errors')->willReturn($messageBag);

        $throwable = new ValidationException($validator);

        $result = $handler->handle($throwable, $response);

        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertStringContainsString('"error":', (string) $result->getBody());
    }

    public function testIsValidShouldReturnTrueForValidationException(): void
    {
        $handler = new ValidationExceptionHandler();

        $validator = $this->createMock(ValidatorInterface::class);
        $throwable = new ValidationException($validator);

        $this->assertTrue($handler->isValid($throwable));
    }

    public function testIsValidShouldReturnFalseForNonValidationException(): void
    {
        $handler = new ValidationExceptionHandler();
        $throwable = $this->createMock(Throwable::class);

        $this->assertFalse($handler->isValid($throwable));
    }
}
