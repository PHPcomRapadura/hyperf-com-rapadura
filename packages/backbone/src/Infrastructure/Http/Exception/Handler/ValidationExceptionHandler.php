<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Http\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Validation\ValidationException;
use JsonException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Swow\Psr7\Message\ResponsePlusInterface;
use Throwable;

use function json_encode;
use function sprintf;

class ValidationExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponsePlusInterface $response): MessageInterface|ResponseInterface
    {
        $this->stopPropagation();
        /** @var ValidationException $throwable */
        $body = $throwable->validator->errors()->getMessages();
        if (! $response->hasHeader('content-type')) {
            $response = $response->addHeader('content-type', 'text/plain; charset=utf-8');
        }
        return $response
            ->setStatus($throwable->status)
            ->setBody(new SwooleStream($this->toJson($body)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }

    private function toJson(array $body): string
    {
        try {
            return json_encode($body, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return sprintf('{"error": "%s"}', $e->getMessage());
        }
    }
}
