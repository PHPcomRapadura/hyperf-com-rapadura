<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Service;

use App\Application\Exception\ExportGamesFailedException;
use App\Application\Service\ExportGameService;
use App\Domain\Collection\GameCollection;
use App\Domain\Entity\Game;
use App\Domain\Repository\GameQueryRepository;
use PHPUnit\Framework\TestCase;
use Serendipity\Hyperf\Testing\Extension\MakeExtension;
use Serendipity\Testing\Extension\BuilderExtension;
use Serendipity\Testing\Extension\FakerExtension;

/**
 * @internal
 */
class ExportGameServiceTest extends TestCase
{
    use MakeExtension;
    use FakerExtension;
    use BuilderExtension;

    public function testShouldExportGameSuccessfully(): void
    {
        $collection = new GameCollection();
        $set1 = $this->faker()->fake(Game::class, ['slug' => 'cool-game']);
        $set2 = $this->faker()->fake(Game::class, ['slug' => 'not-cool-game']);
        $collection->push($this->builder()->build(Game::class, $set1));
        $collection->push($this->builder()->build(Game::class, $set2));
        $gameQueryRepository = $this->createMock(GameQueryRepository::class);
        $gameQueryRepository->expects($this->once())
            ->method('search')
            ->willReturn($collection);

        $service = new ExportGameService($gameQueryRepository);
        $exported = $service->exportGame('cool-game');
        $this->assertEquals($set1->get('slug'), $exported->slug);
    }

    public function testNullIsReturnedWhenNoGames(): void
    {
        $this->expectException(ExportGamesFailedException::class);

        $gameQueryRepository = $this->createMock(GameQueryRepository::class);
        $gameQueryRepository->expects($this->once())
            ->method('search')
            ->willReturn(new GameCollection());

        $service = new ExportGameService($gameQueryRepository);
        $service->exportGame('cool-game');
    }
}
