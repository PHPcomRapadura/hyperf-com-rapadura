<?php

declare(strict_types=1);

namespace App\Presentation\Input\Game;

use App\Infrastructure\Support\Adapter\Input;

class ExportGamesInput extends Input
{
    public function rules(): array
    {
        return [
            'slug' => 'required|string',
        ];
    }
}
