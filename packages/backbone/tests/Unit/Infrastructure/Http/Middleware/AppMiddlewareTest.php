<?php

declare(strict_types=1);

namespace BackboneTest\Unit\Infrastructure\Http\Middleware;

use Backbone\Infrastructure\Http\Middleware\AppMiddleware;
use Backbone\Presentation\Output\NoContent;
use Backbone\Presentation\Output\Output;
use FastRoute\Dispatcher;
use Hyperf\Context\ResponseContext;
use Hyperf\Contract\ConfigInterface;
use Hyperf\HttpServer\Router\Dispatched;
use Hyperf\HttpServer\Router\Handler;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swow\Psr7\Message\ResponsePlusInterface;
use Swow\Psr7\Message\ServerRequestPlusInterface;
use Tests\Support\TestCase;

class AppMiddlewareTest extends TestCase
{
    final public function testShouldRenderOutputResponse(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')
            ->willReturnCallback(fn (string $class) => $this->createMock($class));
        $middleware = new AppMiddleware($container);

        $request = $this->createMock(ServerRequestPlusInterface::class);
        $handler = $this->createMock(RequestHandlerInterface::class);
        $response = $this->createMock(ResponsePlusInterface::class);

        ResponseContext::set($response);

        $properties = [
            'Invalid-Property' => 1,
            'Custom-Property' => 'CustomValue',
        ];
        $output = new Output($properties);

        $request->method('getAttribute')
            ->willReturn(
                new Dispatched([
                    Dispatcher::FOUND,
                    new Handler(fn () => $output, ''),
                    [],
                ])
            );

        $response->expects($this->once())
            ->method('addHeader')
            ->with('content-type', 'application/json')
            ->willReturnSelf();

        $middleware->process($request, $handler);
    }

    final public function testShouldRenderWithoutOutput(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')
            ->willReturnCallback(fn (string $class) => $this->createMock($class));
        $middleware = new AppMiddleware($container);

        $request = $this->createMock(ServerRequestPlusInterface::class);
        $handler = $this->createMock(RequestHandlerInterface::class);
        $response = $this->createMock(ResponsePlusInterface::class);

        ResponseContext::set($response);

        $request->expects($this->once())
            ->method('getAttribute')
            ->willReturn(
                new Dispatched([
                    Dispatcher::FOUND,
                    new Handler(fn () => null, ''),
                    [],
                ])
            );

        $middleware->process($request, $handler);
    }

    /** @noinspection TestingUnfriendlyApisInspection */
    final public function testShouldRenderNoContentResponse(): void
    {
        $config = $this->createMock(ConfigInterface::class);
        $config->expects($this->once())
            ->method('get')
            ->with(sprintf('http.result.%s.status', NoContent::class))
            ->willReturn(204);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')
            ->willReturnCallback(fn (string $class) => match ($class) {
                ConfigInterface::class => $config,
                default => $this->createMock($class),
            });
        $middleware = new AppMiddleware($container);

        $request = $this->createMock(ServerRequestPlusInterface::class);
        $handler = $this->createMock(RequestHandlerInterface::class);
        $response = $this->createMock(ResponsePlusInterface::class);

        ResponseContext::set($response);

        $request->method('getAttribute')
            ->willReturn(
                new Dispatched([
                    Dispatcher::FOUND,
                    new Handler(fn () => new NoContent(), ''),
                    [],
                ])
            );

        $response->expects($this->once())
            ->method('addHeader')
            ->with('content-type', 'application/json')
            ->willReturnSelf();

        $middleware->process($request, $handler);
    }
}
