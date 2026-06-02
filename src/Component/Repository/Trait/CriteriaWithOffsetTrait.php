<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Repository\Trait;

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
        $this->offset = $offset;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }
}
