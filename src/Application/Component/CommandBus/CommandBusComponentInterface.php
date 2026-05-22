<?php

declare(strict_types=1);

namespace Skeleton\Common\Application\Component\CommandBus;

use Skeleton\Common\Application\Command\CommandInterface;

interface CommandBusComponentInterface
{
    /**
     * @template TResult
     *
     * @param CommandInterface<TResult> $command
     *
     * @return TResult
     */
    public function execute(CommandInterface $command);
}
