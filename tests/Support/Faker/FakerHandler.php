<?php

declare(strict_types=1);

namespace Tests\Support\Faker;

use App\Domain\Support\ChainOfResponsibility\Handler;
use Faker\Generator;

abstract class FakerHandler extends Handler
{
    public function __construct(protected readonly Generator $faker)
    {
    }
}
