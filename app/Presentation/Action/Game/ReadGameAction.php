<?php

declare(strict_types=1);

namespace App\Presentation\Action\Game;

use App\Domain\Entity\Game;
use App\Domain\Repository\GameQueryRepository;
use App\Presentation\Input\Game\ReadGameInput;
use Backbone\Presentation\Output\NotFound;

readonly class ReadGameAction
{
    public function __construct(private GameQueryRepository $gameQueryRepository)
    {
    }

    public function __invoke(ReadGameInput $input): Game|NotFound
    {
        $id = $input->value('id', '');
        $game = $this->gameQueryRepository->getGame($id);
        return $game ?? new NotFound(Game::class, $id);
    }
}
