<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\SleekDB;

use App\Domain\Collection\GameCollection;
use App\Domain\Entity\Game;
use App\Domain\Repository\GameQueryRepository;
use Serendipity\Infrastructure\Adapter\SerializerFactory;
use Serendipity\Infrastructure\Database\Document\SleekDBFactory;
use Serendipity\Infrastructure\Database\Managed;
use SleekDB\Exceptions\InvalidArgumentException;
use SleekDB\Exceptions\IOException;

use function Serendipity\Type\Cast\arrayify;

class SleekDBGameQueryRepository extends SleekDBGameRepository implements GameQueryRepository
{
    public function __construct(
        Managed $generator,
        SleekDBFactory $databaseFactory,
        protected readonly SerializerFactory $serializerFactory,
    ) {
        parent::__construct($generator, $databaseFactory);
    }

    /**
     * @throws InvalidArgumentException
     * @throws IOException
     */
    public function getGame(string $id): ?Game
    {
        $data = arrayify($this->database->findBy(['id', '=', $id]));
        $serializer = $this->serializerFactory->make(Game::class);
        return $this->entity($serializer, $data);
    }

    /**
     * @throws IOException
     * @throws InvalidArgumentException
     */
    public function getGames(array $filters = []): GameCollection
    {
        $serializer = $this->serializerFactory->make(Game::class);
        if (empty($filters)) {
            $data = arrayify($this->database->findAll());
            return $this->collection($serializer, $data, GameCollection::class);
        }
        $criteria = [];
        foreach ($filters as $key => $value) {
            $criteria[] = [$key, '=', $value];
        }
        $data = arrayify($this->database->findBy($criteria));
        return $this->collection($serializer, $data, GameCollection::class);
    }
}
