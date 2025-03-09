<?php

declare(strict_types=1);

namespace App\Presentation\Action;

use App\Presentation\Input\HealthInput;

readonly class HealthAction
{
    public function __invoke(HealthInput $input): array
    {
        return [
            'method' => $input->getMethod(),
            'message' => $input->value('message', 'Kicking ass and taking names!'),
        ];
    }
}
