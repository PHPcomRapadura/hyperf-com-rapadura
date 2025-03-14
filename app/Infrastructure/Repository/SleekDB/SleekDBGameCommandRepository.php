<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\SleekDB;

use App\Domain\Entity\Command\GameCommand;
use App\Domain\Repository\GameCommandRepository;
use Serendipity\Domain\Contract\Adapter\Deserializer;
use Serendipity\Domain\Exception\ManagedException;
use Serendipity\Infrastructure\Adapter\DeserializerFactory;
use Serendipity\Infrastructure\Database\Document\SleekDBFactory;
use Serendipity\Infrastructure\Database\Managed;
use SleekDB\Exceptions\IdNotAllowedException;
use SleekDB\Exceptions\InvalidArgumentException;
use SleekDB\Exceptions\IOException;
use SleekDB\Exceptions\JsonException;

use function is_numeric;
use function Serendipity\Type\Cast\arrayify;
use function Serendipity\Type\Cast\integerify;

class SleekDBGameCommandRepository extends SleekDBGameRepository implements GameCommandRepository
{
    /**
     * @var Deserializer<GameCommand>
     */
    protected readonly Deserializer $deserializer;

    public function __construct(
        Managed $generator,
        SleekDBFactory $databaseFactory,
        DeserializerFactory $deserializerFactory,
    ) {
        parent::__construct($generator, $databaseFactory);

        $this->deserializer = $deserializerFactory->make(GameCommand::class);
    }

    /**
     * @throws IOException
     * @throws JsonException
     * @throws IdNotAllowedException
     * @throws InvalidArgumentException
     * @throws ManagedException
     */
    public function create(GameCommand $game): string
    {
        $datum = $this->deserializer->deserialize($game);
        $id = $this->generator->id();
        $datum['id'] = $id;
        $datum['created_at'] = $this->generator->now();
        $datum['updated_at'] = $this->generator->now();
        $this->database->insert($datum);
        return $id;
    }

    /**
     * @throws JsonException
     * @throws InvalidArgumentException
     * @throws IOException
     */
    public function update(int|string $id, GameCommand $game): bool
    {
        $document = arrayify($this->database->findOneBy(['id', '=', $id]));
        if (empty($document) || ! is_numeric($document['_id'] ?? null)) {
            return false;
        }
        $datum = $this->deserializer->deserialize($game);
        $datum['updated_at'] = $this->generator->now();
        return (bool) $this->database->updateById(integerify($document['_id'] ?? null), $datum);
    }

    /**
     * @throws InvalidArgumentException
     * @throws IOException
     */
    public function delete(int|string $id): bool
    {
        return (bool) $this->database->deleteBy(['id', '=', $id]);
    }
}
