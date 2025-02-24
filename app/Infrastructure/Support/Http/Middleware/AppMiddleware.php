<?php

declare(strict_types=1);

namespace App\Infrastructure\Support\Http\Middleware;

use App\Domain\Contract\Result;
use App\Infrastructure\Support\Presentation\OutputFormatter;
use Hyperf\Contract\ConfigInterface;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\CoreMiddleware as Hyperf;
use Hyperf\HttpServer\Router\Dispatched;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface;
use Swow\Psr7\Message\ResponsePlusInterface;

use function Util\Type\Cast\toInt;

class AppMiddleware extends Hyperf
{
    use OutputFormatter;

    private readonly ConfigInterface $config;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container, 'http');

        $this->config = $container->get(ConfigInterface::class);
    }

    protected function handleFound(Dispatched $dispatched, ServerRequestInterface $request): mixed
    {
        $response = parent::handleFound($dispatched, $request);
        if (! $response instanceof Result) {
            return $response;
        }

        $statusCode = $this->normalizeStatusCode($response);

        $output = $this->response()
            ->addHeader('content-type', 'application/json')
            ->withStatus($statusCode);

        $output = $this->configureHeaders($response, $output);

        if ($statusCode === 204) {
            return $output->setBody(new SwooleStream('empty'));
        }

        $body = $response->content()?->toArray();
        $contents = $this->toPayload($statusCode, $body);
        return $output->setBody(new SwooleStream($contents));
    }

    private function normalizeStatusCode(Result $response): int
    {
        $statusCode = toInt($this->config->get(sprintf('http.result.%s.status', $response::class)));
        if ($statusCode === 0) {
            return 200;
        }
        return $statusCode;
    }

    private function configureHeaders(Result $response, ResponsePlusInterface $output): ResponsePlusInterface
    {
        $properties = $response->properties()->toArray();
        foreach ($properties as $key => $value) {
            if (! is_string($value)) {
                continue;
            }
            $output = $output->withAddedHeader(sprintf('X-%s', $key), $value);
        }
        return $output;
    }
}
