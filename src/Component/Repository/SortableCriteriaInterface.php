<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Repository;

use Skeleton\Common\Component\Repository\Enum\SortEnum;

/**
 * Interface for criteria that support sorting.
 *
 * Implementing classes declare which fields and directions are sortable.
 * The actual whitelist validation is performed in the infrastructure mapper
 * before applying sort to a Doctrine query.
 *
 * @see SortableCriteriaTrait Default implementation
 * @see \Skeleton\Common\Component\Repository\Criteria\Mapper\LimitOffsetSortCriteriaMapper
 */
interface SortableCriteriaInterface
{
    /**
     * @param array<string, SortEnum> $order Field name => direction
     */
    public function setSort(array $order): void;

    /**
     * @return array<string, SortEnum> Field name => direction
     */
    public function getSort(): array;
}
