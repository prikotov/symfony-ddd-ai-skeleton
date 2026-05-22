<?php

declare(strict_types=1);

namespace Skeleton\Common\Infrastructure\Component\Event;

use Override;
use RuntimeException;
use Skeleton\Common\Component\Event\EventBusInterface;
use Skeleton\Common\Component\Event\EventInterface;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class SymfonyMessengerEventBus implements EventBusInterface
{
    public function __construct(
        private MessageBusInterface $eventBus,
    ) {
    }

    #[Override]
    public function dispatch(EventInterface $event): void
    {
        try {
            $this->eventBus->dispatch($event);
        } catch (ExceptionInterface $exception) {
            throw new RuntimeException(
                message: sprintf(
                    'Failed to dispatch %s (UUID: %s): %s',
                    $event::class,
                    $event->getEventUuid()->toRfc4122(),
                    $exception->getMessage(),
                ),
                previous: $exception,
            );
        }
    }
}
