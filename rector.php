<?php

/* @noinspection DevelopmentDependenciesUsageInspection */

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $config): void {
    $config->paths([
        __DIR__ . '/app',
        __DIR__ . '/tests',
    ]);

    // register a single rule
    $config->rule(InlineConstructorDefaultToPropertyRector::class);

    $config->skip([AddOverrideAttributeToOverriddenMethodsRector::class]);

    // define sets of rules
    $config->sets([
        LevelSetList::UP_TO_PHP_83,
    ]);

    $config->cacheClass(FileCacheStorage::class);
    $config->cacheDirectory('/tmp/rector');
};
