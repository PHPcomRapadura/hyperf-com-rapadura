<?php

declare(strict_types=1);

namespace App\Presentation\Input\Game;

use Serendipity\Presentation\Input;

class SearchGamesInput extends Input
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string'],
            'slug' => ['sometimes', 'string'],
        ];
    }
}
