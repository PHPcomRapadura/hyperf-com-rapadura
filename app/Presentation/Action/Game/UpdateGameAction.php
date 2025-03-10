<?php

declare(strict_types=1);

namespace App\Presentation\Action\Game;

use App\Domain\Entity\Command\GameCommand;
use App\Domain\Repository\GameCommandRepository;
use App\Presentation\Input\Game\UpdateGameInput;
use Serendipity\Domain\Contract\Message;
use Serendipity\Domain\Exception\ManagedException;
use Serendipity\Infrastructure\Adapter\Serialize\Builder;
use Serendipity\Presentation\Output\Accepted;
use Serendipity\Presentation\Output\Fail\UnprocessableEntity;

readonly class UpdateGameAction
{
    public function __construct(
        private Builder $builder,
        private GameCommandRepository $gameCommandRepository,
    ) {
    }

    /**
     * @throws ManagedException
     */
    public function __invoke(UpdateGameInput $input): Message
    {
        $id = $input->value('id', '');
        $game = $this->builder->build(GameCommand::class, $input->values());
        $updated = $this->gameCommandRepository->update($id, $game);
        return $updated
            ? Accepted::createFrom($id)
            : UnprocessableEntity::createFrom($id);
    }
}
