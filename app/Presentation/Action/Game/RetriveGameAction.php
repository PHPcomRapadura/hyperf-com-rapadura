<?php

declare(strict_types=1);

namespace App\Presentation\Action\Game;

use App\Domain\Entity\Game;
use App\Domain\Repository\GameQueryRepository;
use App\Presentation\Input\Game\ReadGameInput;
use Serendipity\Domain\Contract\Message;
use Serendipity\Presentation\Output\NotFound;
use Serendipity\Presentation\Output\Ok;

readonly class RetriveGameAction
{
    public function __construct(private GameQueryRepository $gameQueryRepository)
    {
    }

    public function __invoke(ReadGameInput $input): Message
    {
        $id = $input->value('id', '');
        $game = $this->gameQueryRepository->getGame($id);
        return $game
            ? Ok::createFrom($game)
            : NotFound::createFrom(Game::class, $id);
    }
}
