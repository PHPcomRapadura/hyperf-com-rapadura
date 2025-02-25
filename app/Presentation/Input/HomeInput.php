<?php

declare(strict_types=1);

namespace App\Presentation\Input;

use Backbone\Infrastructure\Adapter\Input;

class HomeInput extends Input
{
    public function rules(): array
    {
        return [
            'message' => 'sometimes|string',
        ];
    }
}
