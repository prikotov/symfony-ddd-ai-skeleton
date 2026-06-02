<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Repository\Enum;

/**
 * Sort direction for repository criteria.
 *
 * Used as value type in {@see SortableCriteriaInterface::getSort()} array values.
 */
enum SortEnum: string
{
    case asc = 'ASC';
    case desc = 'DESC';
}
