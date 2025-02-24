<?php

declare(strict_types=1);

namespace App\Presentation\Action\Game;

use App\Application\Exception\ExportGamesFailedException;
use App\Application\Service\ExportGameService;
use App\Domain\Entity\Game;
use App\Presentation\Input\Game\ExportGamesInput;

readonly class ExportGamesAction
{
    public function __construct(private ExportGameService $exportGameService)
    {
    }

    /**
     * @throws ExportGamesFailedException
     */
    public function __invoke(ExportGamesInput $input): Game
    {
        $slug = $input->value('slug', '');
        return $this->exportGameService->exportGames($slug);
    }
}
