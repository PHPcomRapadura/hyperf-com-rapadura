<?php

declare(strict_types=1);

namespace App\Presentation\Input\Game;

use Serendipity\Infrastructure\Adapter\Input;

class ReadGameInput extends Input
{
    public function rules(): array
    {
        return [
            'id' => 'required|string',
        ];
    }
}
