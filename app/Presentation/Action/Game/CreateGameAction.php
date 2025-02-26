<?php

declare(strict_types=1);

namespace App\Presentation\Action\Game;

use App\Domain\Entity\Command\GameCommand;
use App\Domain\Repository\GameCommandRepository;
use App\Presentation\Input\Game\CreateGameInput;
use Serendipity\Domain\Contract\Result;
use Serendipity\Domain\Exception\GeneratingException;
use Serendipity\Infrastructure\Adapter\Serializing\Serialize\Builder;
use Serendipity\Presentation\Output\Accepted;

readonly class CreateGameAction
{
    public function __construct(
        private Builder $builder,
        private GameCommandRepository $gameCommandRepository,
    ) {
    }

    /**
     * @throws GeneratingException
     */
    public function __invoke(CreateGameInput $input): Result
    {
        $game = $this->builder->build(GameCommand::class, $input->values());
        $id = $this->gameCommandRepository->persist($game);
        return new Accepted($id);
    }
}
