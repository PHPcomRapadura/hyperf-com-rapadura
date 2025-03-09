<?php

declare(strict_types=1);

use Serendipity\Presentation\Output\Accepted;
use Serendipity\Presentation\Output\Created;
use Serendipity\Presentation\Output\NoContent;
use Serendipity\Presentation\Output\NotFound;
use Serendipity\Presentation\Output\Ok;

return [
    'hosts' => [],
    'result' => [
        Ok::class => [
            'status' => 200,
        ],
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
