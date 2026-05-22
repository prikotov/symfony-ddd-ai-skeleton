<?php

declare(strict_types=1);

namespace Skeleton\Common\Application\Component\QueryBus;

use Skeleton\Common\Application\Query\QueryInterface;

interface QueryBusComponentInterface
{
    /**
     * @template TResult
     *
     * @param QueryInterface<TResult> $query
     *
     * @return TResult
     */
    public function query(QueryInterface $query);
}
