<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Support\Logging;

use App\Infrastructure\Support\Logging\EnvironmentLoggerFactory;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\StdoutLoggerInterface;
use Tests\TestCase;

class EnvironmentLoggerFactoryTest extends TestCase
{
    private StdoutLoggerInterface $stdoutLogger;
    private ConfigInterface $config;
    private EnvironmentLoggerFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->stdoutLogger = $this->createMock(StdoutLoggerInterface::class);
        $this->config = $this->createMock(ConfigInterface::class);
        $this->factory = new EnvironmentLoggerFactory($this->stdoutLogger, $this->config);
    }

    public function testShouldReturnStdoutLoggerForDevEnv(): void
    {
        $logger = $this->factory->make('dev');

        $this->assertSame($this->stdoutLogger, $logger);
    }

    public function testShouldReturnGcloudLoggerForNonDevEnv(): void
    {
        $this->config->method('get')
            ->willReturn(false);

        $logger = $this->factory->make('prd');

        $this->assertNotSame($this->stdoutLogger, $logger);
    }

    public function testShouldReturnBatchGcloudLoggerWhenConfigured(): void
    {
        $this->config->method('get')
            ->with('logger.gcloud.batch', false)
            ->willReturn(true);

        $logger = $this->factory->make('prd');

        $this->assertNotSame($this->stdoutLogger, $logger);
    }
}
