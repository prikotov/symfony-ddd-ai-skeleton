<?php

declare(strict_types=1);

namespace Skeleton\Common\Infrastructure\Component\CommandBus;

use LogicException;
use Override;
use Skeleton\Common\Application\Command\CommandInterface;
use Skeleton\Common\Application\Component\CommandBus\CommandBusComponentInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Handler\HandlersLocatorInterface;

final readonly class CommandBusComponent implements CommandBusComponentInterface
{
    public function __construct(
        private HandlersLocatorInterface $handlersLocator,
    ) {
    }

    #[Override]
    public function execute(CommandInterface $command)
    {
        $envelope = new Envelope($command);
        $handlers = $this->handlersLocator->getHandlers($envelope);

        foreach ($handlers as $handlerDescriptor) {
            $handler = $handlerDescriptor->getHandler();

            return $handler($command);
        }

        throw new LogicException('No handler found for command ' . $command::class);
    }
}
