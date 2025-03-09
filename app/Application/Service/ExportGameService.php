<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Exception\ExportGamesFailedException;
use App\Domain\Entity\Game;
use App\Domain\Repository\GameQueryRepository;

class ExportGameService
{
    public function __construct(private readonly GameQueryRepository $gameQueryRepository)
    {
    }

    /**
     * @throws ExportGamesFailedException
     */
    public function exportGames(string $slug): Game
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
