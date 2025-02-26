<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Http\Middleware;

use Hyperf\Context\Context;
use Hyperf\Contract\ConfigInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;

use function assert;
use function Serendipity\Type\Cast\toString;

class CorsMiddleware
{
    public function __construct(private readonly ConfigInterface $config)
    {
    }

    /**
     * @SuppressWarnings(StaticAccess)
     */
    final public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = Context::get(ResponseInterface::class);
        assert(
            $response instanceof ResponseInterface,
            new RuntimeException('ResponseInterface not found in context')
        );

        $origin = toString($this->config->get('cors.allow_origin', '*'));
        $response = $response->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader(
                'Access-Control-Allow-Headers',
                'DNT,Keep-Alive,User-Agent,Cache-Control,Content-Type,Authorization'
            )
            ->withHeader('Access-Control-Allow-Methods', '*');

        Context::set(ResponseInterface::class, $response);

        if ($request->getMethod() === 'OPTIONS') {
            return $response;
        }

        return $handler->handle($request);
    }
}
