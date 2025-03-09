<?php

declare(strict_types=1);

namespace App\Presentation\Action\Game;

use App\Domain\Entity\Game;
use App\Domain\Repository\GameQueryRepository;
use App\Presentation\Input\Game\GameInput;
use Serendipity\Domain\Contract\Message;
use Serendipity\Presentation\Output\Fail\NotFound;
use Serendipity\Presentation\Output\Ok;

readonly class ReadGameAction
{
    public function __construct(private GameQueryRepository $gameQueryRepository)
    {
    }

    public function __invoke(GameInput $input): Message
    {
        $id = $input->value('id', '');
        $game = $this->gameQueryRepository->read($id);
        return $game
            ? Ok::createFrom($game)
            : NotFound::createFrom(Game::class, $id);
    }
}
