<?php

declare(strict_types=1);

namespace BackboneTest\Unit\Infrastructure\Http\Middleware;

use Backbone\Infrastructure\Http\Middleware\CorsMiddleware;
use Hyperf\Context\Context;
use Hyperf\Contract\ConfigInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Backbone\Infrastructure\Testing\TestCase;

class CorsMiddlewareTest extends TestCase
{
    final public function testShouldAllowCors(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('withHeader')
            ->willReturnSelf();
        Context::set(ResponseInterface::class, $response);

        $config = $this->createMock(ConfigInterface::class);
        $config->expects($this->once())
            ->method('get')
            ->with('cors.allow_origin', '*')
            ->willReturn('*');
        $middleware = new CorsMiddleware($config);

        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('GET');

        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->expects($this->once())
            ->method('handle')
            ->with($request);

        $middleware->process($request, $handler);
    }

    final public function testShouldAllowCorsWhenResponseIsNotInstanceOfResponseInterface(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('withHeader')
            ->willReturnSelf();
        Context::set(ResponseInterface::class, $response);

        $config = $this->createMock(ConfigInterface::class);
        $config->expects($this->once())
            ->method('get')
            ->with('cors.allow_origin', '*')
            ->willReturn('*');
        $middleware = new CorsMiddleware($config);

        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('OPTIONS');

        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->expects($this->never())
            ->method('handle');

        $middleware->process($request, $handler);
    }
}
