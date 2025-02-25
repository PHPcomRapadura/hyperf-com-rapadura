<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Support\Listener;

use App\Infrastructure\Support\Listener\ResumeExitCoordinatorListener;
use Hyperf\Command\Event\AfterExecute;
use Hyperf\Coordinator\Constants;
use Hyperf\Coordinator\CoordinatorManager;
use Tests\Support\TestCase;

class ResumeExitCoordinatorListenerTest extends TestCase
{
    public function testShouldListenToAfterExecuteEvent(): void
    {
        $listener = new ResumeExitCoordinatorListener();
        $this->assertEquals([AfterExecute::class], $listener->listen());
    }

    public function testShouldResumeCoordinatorOnProcess(): void
    {
        $listener = new ResumeExitCoordinatorListener();
        $event = $this->createMock(AfterExecute::class);

        $listener->process($event);

        $this->assertTrue(CoordinatorManager::until(Constants::WORKER_EXIT)->isClosing());
    }
}
