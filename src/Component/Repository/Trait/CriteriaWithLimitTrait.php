<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Repository\Trait;

use InvalidArgumentException;

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
        if ($limit <= 0) {
            throw new InvalidArgumentException('Criteria limit must be greater than zero.');
        }

        $this->limit = $limit;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }
}
