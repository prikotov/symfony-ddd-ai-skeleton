<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Component\Repository\Criteria\Mapper;

use Doctrine\Common\Collections\Order;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Skeleton\Common\Component\Repository\Criteria\Mapper\LimitOffsetSortCriteriaMapper;
use Skeleton\Common\Component\Repository\CriteriaWithLimitInterface;
use Skeleton\Common\Component\Repository\CriteriaWithOffsetInterface;
use Skeleton\Common\Component\Repository\Enum\SortEnum;
use Skeleton\Common\Component\Repository\SortableCriteriaInterface;
use Skeleton\Common\Component\Repository\Trait\CriteriaWithLimitTrait;
use Skeleton\Common\Component\Repository\Trait\CriteriaWithOffsetTrait;
use Skeleton\Common\Component\Repository\Trait\SortableCriteriaTrait;

final class LimitOffsetSortCriteriaMapperTest extends TestCase
{
    private LimitOffsetSortCriteriaMapper $mapper;

    protected function setUp(): void
    {
        $this->mapper = new LimitOffsetSortCriteriaMapper();
    }

    public function testMapAppliesLimit(): void
    {
        $criteria = $this->createCriteria(limit: 25);
        $result = $this->mapper->map($criteria, []);

        self::assertSame(25, $result->getMaxResults());
    }

    public function testMapAppliesOffset(): void
    {
        $criteria = $this->createCriteria(offset: 50);
        $result = $this->mapper->map($criteria, []);

        self::assertSame(50, $result->getFirstResult());
    }

    public function testMapAppliesLimitAndOffsetTogether(): void
    {
        $criteria = $this->createCriteria(limit: 10, offset: 20);
        $result = $this->mapper->map($criteria, []);

        self::assertSame(10, $result->getMaxResults());
        self::assertSame(20, $result->getFirstResult());
    }

    public function testMapAppliesSortWithValidWhitelist(): void
    {
        $criteria = $this->createCriteria(sort: ['name' => SortEnum::asc]);
        $whitelist = ['name' => 'e.name', 'id' => 'e.id'];

        $result = $this->mapper->map($criteria, $whitelist);

        $orderings = $result->orderings();
        self::assertArrayHasKey('e.name', $orderings);
        self::assertSame(Order::Ascending, $orderings['e.name']);
    }

    public function testMapAppliesMultipleSortFields(): void
    {
        $criteria = $this->createCriteria(sort: [
            'name' => SortEnum::asc,
            'id' => SortEnum::desc,
        ]);
        $whitelist = ['name' => 'e.name', 'id' => 'e.id'];

        $result = $this->mapper->map($criteria, $whitelist);

        $orderings = $result->orderings();
        self::assertCount(2, $orderings);
        self::assertSame(Order::Ascending, $orderings['e.name']);
        self::assertSame(Order::Descending, $orderings['e.id']);
    }

    public function testMapThrowsOnUnknownSortField(): void
    {
        $criteria = $this->createCriteria(sort: ['unknownField' => SortEnum::asc]);
        $whitelist = ['name' => 'e.name'];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Sort field "unknownField" is not in the allowed list.');

        $this->mapper->map($criteria, $whitelist);
    }

    public function testMapThrowsOnEmptyWhitelistWhenSortRequested(): void
    {
        $criteria = $this->createCriteria(sort: ['name' => SortEnum::asc]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Sort field "name" is not in the allowed list. Allowed fields:');

        $this->mapper->map($criteria, []);
    }

    public function testMapReturnsEmptyCriteriaForPlainObject(): void
    {
        $plainObject = new \stdClass();
        $result = $this->mapper->map($plainObject, []);

        self::assertNull($result->getMaxResults());
        self::assertSame(0, $result->getFirstResult());
        self::assertEmpty($result->orderings());
    }

    public function testMapWithNoSortAndNoLimitOffsetReturnsEmptyCriteria(): void
    {
        $criteria = $this->createCriteria();
        $result = $this->mapper->map($criteria, ['id' => 'e.id']);

        self::assertNull($result->getMaxResults());
        self::assertSame(0, $result->getFirstResult());
        self::assertEmpty($result->orderings());
    }

    public function testMapMapsSortFieldToDoctrineFieldPath(): void
    {
        $criteria = $this->createCriteria(sort: ['createdAt' => SortEnum::desc]);
        $whitelist = ['createdAt' => 'entity.insTs'];

        $result = $this->mapper->map($criteria, $whitelist);

        $orderings = $result->orderings();
        self::assertArrayHasKey('entity.insTs', $orderings);
        self::assertSame(Order::Descending, $orderings['entity.insTs']);
    }

    public function testMapSkipsNullLimit(): void
    {
        $criteria = $this->createCriteria(limit: null);
        $result = $this->mapper->map($criteria, []);

        self::assertNull($result->getMaxResults());
    }

    public function testMapAppliesZeroOffset(): void
    {
        $criteria = $this->createCriteria(offset: 0);
        $result = $this->mapper->map($criteria, []);

        self::assertSame(0, $result->getFirstResult());
    }

    /**
     * Creates a test criteria fixture implementing all three interfaces.
     */
    private function createCriteria(
        ?int $limit = null,
        ?int $offset = null,
        array $sort = [],
    ): object {
        return new class($limit, $offset, $sort) implements
            SortableCriteriaInterface,
            CriteriaWithLimitInterface,
            CriteriaWithOffsetInterface
        {
            use SortableCriteriaTrait;
            use CriteriaWithLimitTrait;
            use CriteriaWithOffsetTrait;

            public function __construct(?int $limit, ?int $offset, array $sort)
            {
                if ($limit !== null) {
                    $this->setLimit($limit);
                }
                if ($offset !== null) {
                    $this->setOffset($offset);
                }
                if ($sort !== []) {
                    $this->setSort($sort);
                }
            }
        };
    }
}
