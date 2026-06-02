<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Repository\Criteria\Mapper;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Order;
use InvalidArgumentException;
use Skeleton\Common\Component\Repository\CriteriaWithLimitInterface;
use Skeleton\Common\Component\Repository\CriteriaWithOffsetInterface;
use Skeleton\Common\Component\Repository\Enum\SortEnum;
use Skeleton\Common\Component\Repository\SortableCriteriaInterface;

/**
 * Maps limit/offset/sort from domain criteria to a Doctrine {@see Criteria} object.
 *
 * **Sort whitelist is mandatory.** Every sort field present in the criteria must
 * have a corresponding entry in `$allowedSortFields`; otherwise an
 * {@see InvalidArgumentException} is thrown. This prevents SQL-injection and
 * ensures that only intentionally exposed fields are used for ordering.
 *
 * ## Usage example (inside a concrete CriteriaMapper)
 *
 * ```php
 * final readonly class ItemFindCriteriaMapper
 * {
 *     public function __construct(
 *         private LimitOffsetSortCriteriaMapper $limitOffsetSortMapper,
 *     ) {}
 *
 *     private const SORT_WHITELIST = [
 *         'name'      => 'item.name',
 *         'createdAt' => 'item.createdAt',
 *     ];
 *
 *     public function map(ItemRepository $repo, ItemFindCriteria $criteria): QueryBuilder
 *     {
 *         $qb = $repo->createQueryBuilder('item');
 *
 *         // … apply domain-specific filters …
 *
 *         $doctrineCriteria = $this->limitOffsetSortMapper->map($criteria, self::SORT_WHITELIST);
 *         $qb->addCriteria($doctrineCriteria);
 *
 *         return $qb;
 *     }
 * }
 * ```
 *
 * ## Stable ordering
 *
 * When using pagination, always add a unique field (e.g. `id`) as the last
 * sort field to guarantee deterministic results across pages:
 *
 * ```php
 * private const SORT_WHITELIST = [
 *     'name' => 'item.name',
 *     'id'   => 'item.id',   // guarantees stable ordering
 * ];
 * ```
 */
final readonly class LimitOffsetSortCriteriaMapper
{
    /**
     * Maps criteria limit/offset/sort to a Doctrine Criteria.
     *
     * @param object $criteria A criteria object implementing any combination of
     *                         {@see SortableCriteriaInterface},
     *                         {@see CriteriaWithLimitInterface},
     *                         {@see CriteriaWithOffsetInterface}.
     * @param array<string, string> $allowedSortFields Map of sort field name
     *                         (as used in criteria) to Doctrine field path.
     *                         Example: `['name' => 'e.name', 'id' => 'e.id']`.
     *                         Must be non-empty when sort is requested.
     *
     * @throws InvalidArgumentException If a sort field is not in the whitelist.
     */
    public function map(object $criteria, array $allowedSortFields): Criteria
    {
        $doctrineCriteria = Criteria::create();

        if ($criteria instanceof CriteriaWithLimitInterface) {
            $limit = $criteria->getLimit();
            if ($limit !== null) {
                $doctrineCriteria->setMaxResults($limit);
            }
        }

        if ($criteria instanceof CriteriaWithOffsetInterface) {
            $offset = $criteria->getOffset();
            if ($offset !== null) {
                $doctrineCriteria->setFirstResult($offset);
            }
        }

        if ($criteria instanceof SortableCriteriaInterface) {
            $this->applySort($doctrineCriteria, $criteria, $allowedSortFields);
        }

        return $doctrineCriteria;
    }

    /**
     * @param array<string, string> $allowedSortFields
     */
    private function applySort(
        Criteria $doctrineCriteria,
        SortableCriteriaInterface $criteria,
        array $allowedSortFields,
    ): void {
        $sort = $criteria->getSort();

        if ($sort === []) {
            return;
        }

        /** @var array<string, Order> $orderings */
        $orderings = [];

        foreach ($sort as $field => $direction) {
            if (!isset($allowedSortFields[$field])) {
                throw new InvalidArgumentException(sprintf(
                    'Sort field "%s" is not in the allowed list. Allowed fields: %s',
                    $field,
                    implode(', ', array_keys($allowedSortFields)),
                ));
            }

            $doctrineField = $allowedSortFields[$field];
            $orderings[$doctrineField] = $this->toDoctrineOrder($direction);
        }

        $doctrineCriteria->orderBy($orderings);
    }

    private function toDoctrineOrder(SortEnum $direction): Order
    {
        return $direction === SortEnum::asc ? Order::Ascending : Order::Descending;
    }
}
