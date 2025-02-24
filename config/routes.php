<?php

declare(strict_types=1);

use App\Presentation\Action\Game\CreateGameAction;
use App\Presentation\Action\Game\ExportGamesAction;
use App\Presentation\Action\Game\ReadGameAction;
use App\Presentation\Action\HomeAction;
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', HomeAction::class);

Router::get('/favicon.ico', static fn () => '');

Router::post('/error', static fn () => throw new Exception('Error!'));

Router::addGroup('/api/v1/', function () {
    Router::post('games', CreateGameAction::class);
    Router::get('games/{id}', ReadGameAction::class);
//    Router::patch('games/{id}', UpdateGameAction::class);
//    Router::delete('games/{id}', DeleteGameAction::class);
//    Router::get('games', SearchGameAction::class);
    Router::post('games/{slug}/export', ExportGamesAction::class);
});
