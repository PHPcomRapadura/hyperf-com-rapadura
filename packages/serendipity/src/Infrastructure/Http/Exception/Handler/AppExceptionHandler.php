<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Http\Exception\Handler;

use Serendipity\Presentation\OutputFormatter;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Throwable;

use function array_map;
use function Serendipity\Type\Cast\toInt;
use function Serendipity\Type\Cast\toString;
use function in_array;
use function sprintf;

class AppExceptionHandler extends ExceptionHandler
{
    use OutputFormatter;

    /**
     * @var array<string>
     */
    private array $ignored = [];

    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function handle(Throwable $throwable, ResponseInterface $response): MessageInterface|ResponseInterface
    {
        $message = sprintf(
            '[app.error] "%s" in `%s` at `%s`',
            $throwable->getMessage(),
            $throwable->getFile(),
            $throwable->getLine()
        );
        $context = [
            'message' => $throwable->getMessage(),
            'file' => $throwable->getFile(),
            'line' => $throwable->getLine(),
            'code' => $throwable->getCode(),
            'kind' => $throwable::class,
            'trace' => $throwable->getTraceAsString(),
        ];

        $this->logger->error($message, $context);

        $statusCode = $this->extractCode($throwable);

        return $response->withStatus($statusCode)
            ->withBody(new SwooleStream($this->toPayload($statusCode, $context)));
    }

    public function isValid(Throwable $throwable): bool
    {
        $haystack = array_map(fn (mixed $candidate) => toString($candidate), $this->ignored);
        return ! in_array($throwable::class, $haystack, true);
    }

    private function extractCode(Throwable $throwable): int
    {
        return ($code = $throwable->getCode()) >= 400 && $code < 600 ? toInt($code) : 500;
    }
}
