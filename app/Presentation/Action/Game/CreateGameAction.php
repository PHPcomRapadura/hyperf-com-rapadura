<?php

declare(strict_types=1);

namespace App\Presentation\Action\Game;

use App\Domain\Entity\Command\GameCommand;
use App\Domain\Repository\GameCommandRepository;
use App\Presentation\Input\Game\CreateGameInput;
use Serendipity\Domain\Contract\Message;
use Serendipity\Domain\Exception\ManagedException;
use Serendipity\Infrastructure\Adapter\Serialize\Builder;
use Serendipity\Presentation\Output\Accepted;

readonly class CreateGameAction
{
    public function __construct(
        private Builder $builder,
        private GameCommandRepository $gameCommandRepository,
    ) {
    }

    /**
     * @throws ManagedException
     */
    public function __invoke(CreateGameInput $input): Message
    {
        $game = $this->builder->build(GameCommand::class, $input->values());
        $id = $this->gameCommandRepository->create($game);
        return Accepted::createFrom($id);
    }
}
