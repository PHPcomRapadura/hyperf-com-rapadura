<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Service;

use App\Application\Exception\ExportGamesFailedException;
use App\Application\Service\ExportGameService;
use App\Domain\Collection\GameCollection;
use App\Domain\Entity\Game;
use App\Domain\Repository\GameQueryRepository;
use Backbone\Domain\Contract\Serializer;
use DateTimeImmutable;
use Tests\Support\TestCase;

class ExportGameServiceTest extends TestCase
{
    public function testShouldExportGameSuccessfully(): void
    {
        $serializer = $this->createMock(Serializer::class);
        $serializer->expects($this->once())
            ->method('serialize')
            ->willReturn(new Game(
                id: 'cool',
                createdAt: new DateTimeImmutable(),
                updatedAt: new DateTimeImmutable(),
                name: 'Cool Game',
                slug: 'cool-game',
            ));

        $gameQueryRepository = $this->createMock(GameQueryRepository::class);
        $gameQueryRepository->expects($this->once())
            ->method('getGames')
            ->willReturn(GameCollection::createFrom([[]], $serializer));

        $service = new ExportGameService($gameQueryRepository);
        $service->exportGames('cool-game');
    }

    public function testNullIsReturnedWhenNoGames(): void
    {
        $this->expectException(ExportGamesFailedException::class);

        $serializer = $this->createMock(Serializer::class);
        $gameQueryRepository = $this->createMock(GameQueryRepository::class);
        $gameQueryRepository->expects($this->once())
            ->method('getGames')
            ->willReturn(GameCollection::createFrom([], $serializer));

        $service = new ExportGameService($gameQueryRepository);
        $service->exportGames('cool-game');
    }
}
