<?php

declare(strict_types=1);

namespace App\Presentation\Action\Game;

use App\Domain\Repository\GameQueryRepository;
use App\Presentation\Input\Game\SearchGamesInput;
use Serendipity\Domain\Contract\Message;
use Serendipity\Presentation\Output\Ok;

readonly class SearchGamesAction
{
    public function __construct(private GameQueryRepository $gameQueryRepository)
    {
    }

    public function __invoke(SearchGamesInput $input): Message
    {
        $name = $input->value('name');
        $slug = $input->value('slug');
        $games = $this->gameQueryRepository->getGames([
            'names' => $name,
            'slug' => $slug,
        ]);
        return Ok::createFrom($games);
    }
}
