<?php

declare(strict_types=1);

namespace Skeleton\Common\Infrastructure\Component\QueryBus;

use LogicException;
use Override;
use Skeleton\Common\Application\Component\QueryBus\QueryBusComponentInterface;
use Skeleton\Common\Application\Query\QueryInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Handler\HandlersLocatorInterface;

final readonly class QueryBusComponent implements QueryBusComponentInterface
{
    public function __construct(
        private HandlersLocatorInterface $handlersLocator,
    ) {
    }

    #[Override]
    public function query(QueryInterface $query)
    {
        $envelope = new Envelope($query);
        $handlers = $this->handlersLocator->getHandlers($envelope);

        foreach ($handlers as $handlerDescriptor) {
            $handler = $handlerDescriptor->getHandler();

            return $handler($query);
        }

        throw new LogicException('No handler found for query ' . $query::class);
    }
}
