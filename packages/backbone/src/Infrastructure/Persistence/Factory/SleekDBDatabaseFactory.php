<?php

declare(strict_types=1);

namespace Backbone\Infrastructure\Persistence\Factory;

use Hyperf\Contract\ConfigInterface;
use SleekDB\Exceptions\InvalidArgumentException;
use SleekDB\Exceptions\InvalidConfigurationException;
use SleekDB\Exceptions\IOException;
use SleekDB\Store;

use function Backbone\Util\Type\Cast\toArray;
use function Backbone\Util\Type\Cast\toString;

class SleekDBDatabaseFactory
{
    public function __construct(private readonly ConfigInterface $config)
    {
    }

    /**
     * @throws InvalidConfigurationException
     * @throws InvalidArgumentException
     * @throws IOException
     */
    public function make(string $resource): Store
    {
        $path = toString($this->config->get('databases.sleek.path'));
        $configuration = toArray($this->config->get('databases.sleek.configuration'));
        return new Store($resource, $path, $configuration);
    }
}
