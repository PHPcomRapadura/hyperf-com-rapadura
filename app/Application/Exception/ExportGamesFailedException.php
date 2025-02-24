<?php

declare(strict_types=1);

namespace App\Application\Exception;

use Exception;

final class ExportGamesFailedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Game not found', 404);
    }
}
