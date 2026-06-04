<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Repository\Trait;

use InvalidArgumentException;

/**
 * Default implementation of {@see \Skeleton\Common\Component\Repository\CriteriaWithOffsetInterface}.
 *
 * Class using this trait must implement CriteriaWithOffsetInterface explicitly.
 */
trait CriteriaWithOffsetTrait
{
    private ?int $offset = null;

    public function setOffset(int $offset): void
    {
        if ($offset < 0) {
            throw new InvalidArgumentException('Criteria offset must not be negative.');
        }

        $this->offset = $offset;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }
}
