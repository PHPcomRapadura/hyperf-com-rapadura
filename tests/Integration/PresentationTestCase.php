<?php

declare(strict_types=1);

namespace Tests\Integration;

use Serendipity\Hyperf\Testing\Extension\InputExtension;
use Serendipity\Hyperf\Testing\Extension\MakeExtension;
use Serendipity\Hyperf\Testing\PostgresHelper;
use Serendipity\Hyperf\Testing\SleekDBHelper;
use Tests\ExtensibleTestCase;
use Serendipity\Testing\Extension\FakerExtension;
use Serendipity\Testing\Extension\ResourceExtension;

/**
 * @internal
 */
abstract class PresentationTestCase extends ExtensibleTestCase
{
    use MakeExtension;
    use FakerExtension;
    use ResourceExtension;
    use InputExtension;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpInput();

        $this->setUpResourceHelper('sleek', $this->make(SleekDBHelper::class));
        $this->setUpResourceHelper('postgres', $this->make(PostgresHelper::class));
    }
}
