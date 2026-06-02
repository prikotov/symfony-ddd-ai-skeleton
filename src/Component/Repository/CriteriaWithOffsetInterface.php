<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Repository;

/**
 * Interface for criteria that support result offset.
 *
 * @see CriteriaWithOffsetTrait Default implementation
 */
interface CriteriaWithOffsetInterface
{
    public function setOffset(int $offset): void;

    public function getOffset(): ?int;
}
