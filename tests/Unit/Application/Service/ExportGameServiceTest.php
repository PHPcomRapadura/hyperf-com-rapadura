<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Service;

use App\Application\Exception\ExportGamesFailedException;
use App\Application\Service\ExportGameService;
use App\Domain\Collection\GameCollection;
use App\Domain\Repository\GameQueryRepository;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class ExportGameServiceTest extends TestCase
{
    public function testShouldExportGameSuccessfully(): void
    {
        $gameQueryRepository = $this->createMock(GameQueryRepository::class);
        $gameQueryRepository->expects($this->once())
            ->method('getGames')
            ->willReturn(new GameCollection());

        $service = new ExportGameService($gameQueryRepository);
        $service->exportGames('cool-game');
    }

    public function testNullIsReturnedWhenNoGames(): void
    {
        $this->expectException(ExportGamesFailedException::class);

        $gameQueryRepository = $this->createMock(GameQueryRepository::class);
        $gameQueryRepository->expects($this->once())
            ->method('getGames')
            ->willReturn(new GameCollection());

        $service = new ExportGameService($gameQueryRepository);
        $service->exportGames('cool-game');
    }
}
