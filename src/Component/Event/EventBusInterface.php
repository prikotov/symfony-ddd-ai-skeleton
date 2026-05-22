<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Event;

interface EventBusInterface
{
    public function dispatch(EventInterface $event): void;
}
