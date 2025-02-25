<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Infrastructure\Support\Adapter\Mapping\Mapper;
use App\Infrastructure\Support\Persistence\Hyperf\HyperfDBFactory;
use App\Infrastructure\Support\Persistence\SleekDB\SleekDBDatabaseFactory;
use Tests\Integration\Support\Database\Helper;
use Tests\Integration\Support\Database\Helpers\SleekDBHelper;
use Tests\Integration\Support\Database\Helpers\PostgresHelper;
use Tests\TestCase;

class IntegrationTestCase extends TestCase
{
    protected Helper $sleek;

    protected Mapper $mapper;

    protected PostgresHelper $postgres;

    protected array $truncate = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->mapper = $this->make(Mapper::class);

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
                default => null,
            };
        }
    }
}
