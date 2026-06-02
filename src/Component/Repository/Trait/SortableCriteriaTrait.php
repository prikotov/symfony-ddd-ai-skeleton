<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Repository\Trait;

use InvalidArgumentException;
use Skeleton\Common\Component\Repository\Enum\SortEnum;

/**
 * Default implementation of {@see \Skeleton\Common\Component\Repository\SortableCriteriaInterface}.
 *
 * Class using this trait must implement SortableCriteriaInterface explicitly.
 */
trait SortableCriteriaTrait
{
    /**
     * @var array<string, SortEnum>
     */
    private array $order = [];

    /**
     * @param array<string, SortEnum> $order
     */
    public function setSort(array $order): void
    {
        foreach ($order as $field => $direction) {
            if (!$direction instanceof SortEnum) {
                throw new InvalidArgumentException(sprintf(
                    'Sort direction for field "%s" must be an instance of SortEnum.',
                    $field,
                ));
            }
        }

        $this->order = $order;
    }

    /**
     * @return array<string, SortEnum>
     */
    public function getSort(): array
    {
        return $this->order;
    }
}
