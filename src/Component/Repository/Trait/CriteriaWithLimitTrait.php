<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Repository\Trait;

/**
 * Default implementation of {@see \Skeleton\Common\Component\Repository\CriteriaWithLimitInterface}.
 *
 * Class using this trait must implement CriteriaWithLimitInterface explicitly.
 */
trait CriteriaWithLimitTrait
{
    private ?int $limit = null;

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }
}
