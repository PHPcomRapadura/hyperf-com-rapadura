<?php

declare(strict_types=1);

namespace App\Presentation\Input\Game;

use Serendipity\Presentation\Input;

class UpdateGameInput extends Input
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'string'],
            'name' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'data' => ['sometimes', 'array'],
        ];
    }
}
