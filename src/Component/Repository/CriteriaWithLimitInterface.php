<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Repository;

/**
 * Interface for criteria that support result limiting.
 *
 * @see CriteriaWithLimitTrait Default implementation
 */
interface CriteriaWithLimitInterface
{
    public function setLimit(int $limit): void;

    public function getLimit(): ?int;
}
