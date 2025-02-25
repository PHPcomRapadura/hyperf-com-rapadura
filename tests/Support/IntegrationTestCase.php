<?php

declare(strict_types=1);

namespace Tests\Support;

use Backbone\Infrastructure\Adapter\Serializing\Serialize\Builder;
use Backbone\Infrastructure\Persistence\Factory\HyperfDBFactory;
use Backbone\Infrastructure\Persistence\Factory\SleekDBDatabaseFactory;
use BackboneTest\Support\Database\Helper;
use BackboneTest\Support\Database\Helpers\PostgresHelper;
use BackboneTest\Support\Database\Helpers\SleekDBHelper;

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
