<?php

declare(strict_types=1);

namespace Serendipity\Infrastructure\Logging;

use Google\Cloud\Logging\LoggingClient;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\StdoutLoggerInterface;
use Psr\Log\LoggerInterface;

use function Serendipity\Type\Cast\toString;
use function Hyperf\Support\env;

readonly class EnvironmentLoggerFactory
{
    public function __construct(
        private StdoutLoggerInterface $stdoutLogger,
        private ConfigInterface $config,
    ) {
    }

    public function make(string $env = 'dev'): LoggerInterface
    {
        if ($env === 'dev') {
            return $this->stdoutLogger;
        }

        $logging = new LoggingClient([
            'projectId' => env('GOOGLE_CLOUD_PROJECT') ?: 'unknown',
        ]);
        $options = [];
        if ($this->config->get('logger.gcloud.batch', false)) {
            $options = [
                'batchEnabled' => true,
                'batchOptions' => [
                    'batchSize' => 50,
                    'callPeriod' => 5,
                ],
            ];
        }
        return $logging->psrLogger(toString(env('APP_NAME')), $options);
    }
}
