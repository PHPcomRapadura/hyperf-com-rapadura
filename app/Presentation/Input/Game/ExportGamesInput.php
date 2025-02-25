<?php

declare(strict_types=1);

namespace App\Presentation\Input\Game;

use Backbone\Infrastructure\Adapter\Input;

class ExportGamesInput extends Input
{
    public function rules(): array
    {
        return [
            'slug' => 'required|string',
        ];
    }
}
