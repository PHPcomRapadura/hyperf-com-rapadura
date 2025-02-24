<?php

declare(strict_types=1);

namespace App\Presentation\Action\Game;

use App\Domain\Contract\Result;
use App\Domain\Entity\Command\GameCommand;
use App\Domain\Exception\GeneratingException;
use App\Domain\Repository\GameCommandRepository;
use App\Infrastructure\Support\Adapter\Mapping\Mapper;
use App\Infrastructure\Support\Presentation\Output\Accepted;
use App\Presentation\Input\Game\CreateGameInput;

readonly class CreateGameAction
{
    public function __construct(
        private Mapper $mapper,
        private GameCommandRepository $gameCommandRepository,
    ) {
    }

    /**
     * @throws GeneratingException
     */
    public function __invoke(CreateGameInput $input): Result
    {
        $game = $this->mapper->map(GameCommand::class, $input->values());
        $id = $this->gameCommandRepository->persist($game);
        return new Accepted($id);
    }
}
