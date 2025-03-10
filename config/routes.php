<?php

declare(strict_types=1);

use App\Presentation\Action\Game\CreateGameAction;
use App\Presentation\Action\Game\DeleteGameAction;
use App\Presentation\Action\Game\ExportGameAction;
use App\Presentation\Action\Game\ReadGameAction;
use App\Presentation\Action\Game\SearchGamesAction;
use App\Presentation\Action\Game\UpdateGameAction;
use App\Presentation\Action\HealthAction;
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/health', HealthAction::class);

Router::get('/favicon.ico', static fn () => '');

Router::addGroup('/api/v1/', function () {
    Router::post('games', CreateGameAction::class);
    Router::get('games/{id}', ReadGameAction::class);
    Router::put('games/{id}', UpdateGameAction::class);
    Router::delete('games/{id}', DeleteGameAction::class);
    Router::get('games', SearchGamesAction::class);
    Router::post('games/{slug}/export', ExportGameAction::class);
});
