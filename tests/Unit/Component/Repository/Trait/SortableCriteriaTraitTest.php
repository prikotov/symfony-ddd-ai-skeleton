<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Component\Repository\Trait;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Skeleton\Common\Component\Repository\Enum\SortEnum;
use Skeleton\Common\Component\Repository\SortableCriteriaInterface;
use Skeleton\Common\Component\Repository\Trait\SortableCriteriaTrait;

final class SortableCriteriaTraitTest extends TestCase
{
    public function testSetSortAcceptsSortEnumDirections(): void
    {
        $criteria = $this->createCriteria();

        $criteria->setSort(['displayName' => SortEnum::asc]);

        self::assertSame(['displayName' => SortEnum::asc], $criteria->getSort());
    }

    public function testSetSortRejectsInvalidSortDirection(): void
    {
        $criteria = $this->createCriteria();

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Sort direction for field "displayName" must be an instance of SortEnum.');

        $criteria->setSort(['displayName' => 'not-a-sort-enum']);
    }

    private function createCriteria(): SortableCriteriaInterface
    {
        return new class implements SortableCriteriaInterface {
            use SortableCriteriaTrait;
        };
    }
}
