<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Support\Adapter;

use App\Infrastructure\Support\Adapter\Input;

class InputTestStub extends Input
{
    public function rules(): array
    {
        return [
            'test' => 'sometimes|string',
            'datum' => 'sometimes|string',
            'param' => 'sometimes|string',
        ];
    }
}
