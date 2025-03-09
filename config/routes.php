<?php

declare(strict_types=1);

use App\Presentation\Action\GetQuoteRxmgAction;
use App\Presentation\Action\HealthAction;
use App\Presentation\Action\ProcessRxmgAction;
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/health', HealthAction::class);

Router::get('/favicon.ico', static fn () => '');

Router::addGroup('/api/v1/', function () {
    Router::post('games', CreateGameAction::class);
    Router::get('games/{id}', ReadGameAction::class);
//    Router::patch('games/{id}', UpdateGameAction::class);
//    Router::delete('games/{id}', DeleteGameAction::class);
//    Router::get('games', SearchGameAction::class);
    Router::post('games/{slug}/export', ExportGamesAction::class);
});
