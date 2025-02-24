<?php

use App\Infrastructure\Support\Presentation\Output\Accepted;
use App\Infrastructure\Support\Presentation\Output\Created;
use App\Infrastructure\Support\Presentation\Output\NoContent;
use App\Infrastructure\Support\Presentation\Output\NotFound;

return [
    'result' => [
        Created::class => [
            'status' => 201,
        ],
        Accepted::class => [
            'status' => 202,
        ],
        NoContent::class => [
            'status' => 204,
        ],
        NotFound::class => [
            'status' => 404,
        ],
    ],
];
