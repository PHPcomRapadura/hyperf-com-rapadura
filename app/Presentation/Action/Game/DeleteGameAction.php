<?php

declare(strict_types=1);

namespace App\Presentation\Action\Game;

use App\Domain\Repository\GameCommandRepository;
use App\Presentation\Input\Game\GameInput;
use Serendipity\Domain\Contract\Message;
use Serendipity\Presentation\Output\Accepted;
use Serendipity\Presentation\Output\Fail\UnprocessableEntity;

readonly class DeleteGameAction
{
    public function __construct(private GameCommandRepository $gameCommandRepository)
    {
    }

    public function __invoke(GameInput $input): Message
    {
        $id = $input->value('id', '');
        $deleted = $this->gameCommandRepository->delete($id);
        return $deleted
            ? Accepted::createFrom($id)
            : UnprocessableEntity::createFrom($id);
    }
}
