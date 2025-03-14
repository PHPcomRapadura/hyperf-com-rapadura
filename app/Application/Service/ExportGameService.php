<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Exception\ExportGamesFailedException;
use App\Domain\Entity\Game;
use App\Infrastructure\Repository\Postgres\PostgresGameQueryRepository;

class ExportGameService
{
    public function __construct(private readonly PostgresGameQueryRepository $gameQueryRepository)
    {
    }

    /**
     * @throws ExportGamesFailedException
     */
    public function exportGame(string $slug): Game
    {
        $games = $this->gameQueryRepository->search();
        foreach ($games as $game) {
            if ($game->slug === $slug) {
                return $game;
            }
        }
        throw new ExportGamesFailedException();
    }
}
