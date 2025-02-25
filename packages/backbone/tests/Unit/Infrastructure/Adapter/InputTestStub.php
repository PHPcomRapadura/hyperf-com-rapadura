<?php

declare(strict_types=1);

namespace BackboneTest\Unit\Infrastructure\Adapter;

use Backbone\Infrastructure\Adapter\Input;

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
