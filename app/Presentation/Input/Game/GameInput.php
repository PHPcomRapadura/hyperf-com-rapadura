<?php

declare(strict_types=1);

namespace App\Presentation\Input\Game;

use Serendipity\Presentation\Input;

class GameInput extends Input
{
    public function rules(): array
    {
        return [
            'id' => 'required|string',
        ];
    }
}
