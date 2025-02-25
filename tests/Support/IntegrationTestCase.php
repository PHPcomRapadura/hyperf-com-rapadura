<?php

declare(strict_types=1);

namespace Tests\Support;

use App\Infrastructure\Support\Adapter\Serializing\Serialize\Builder;
use App\Infrastructure\Support\Persistence\Hyperf\HyperfDBFactory;
use App\Infrastructure\Support\Persistence\SleekDB\SleekDBDatabaseFactory;
use Tests\Integration\Support\Database\Helper;
use Tests\Integration\Support\Database\Helpers\PostgresHelper;
use Tests\Integration\Support\Database\Helpers\SleekDBHelper;

class IntegrationTestCase extends TestCase
{
    protected Helper $sleek;

    protected Builder $mapper;

    protected PostgresHelper $postgres;

    protected array $truncate = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->mapper = $this->make(Builder::class);

        $this->sleek = new SleekDBHelper($this->make(SleekDBDatabaseFactory::class), $this);

        $this->postgres = new PostgresHelper($this->make(HyperfDBFactory::class)->make('postgres'), $this);

        $this->truncate();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->truncate();
    }

    protected function truncate(): void
    {
        foreach ($this->truncate as $resource => $database) {
            match ($database) {
                'sleek' => $this->sleek->truncate($resource),
                'postgres' => $this->postgres->truncate($resource),
                default => null,
            };
        }
    }
}
