<?php

declare(strict_types=1);

namespace App\Presentation\Input\Game;

use Serendipity\Infrastructure\Adapter\Input;

class CreateGameInput extends Input
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'data' => ['sometimes', 'array'],
        ];
    }
}
