<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Component\Repository\Trait;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Skeleton\Common\Component\Repository\CriteriaWithLimitInterface;
use Skeleton\Common\Component\Repository\Trait\CriteriaWithLimitTrait;

final class CriteriaWithLimitTraitTest extends TestCase
{
    public function testSetLimitAcceptsPositiveLimit(): void
    {
        $criteria = $this->createCriteria();

        $criteria->setLimit(10);

        self::assertSame(10, $criteria->getLimit());
    }

    public function testSetLimitRejectsZeroLimit(): void
    {
        $criteria = $this->createCriteria();

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Criteria limit must be greater than zero.');

        $criteria->setLimit(0);
    }

    public function testSetLimitRejectsNegativeLimit(): void
    {
        $criteria = $this->createCriteria();

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Criteria limit must be greater than zero.');

        $criteria->setLimit(-1);
    }

    private function createCriteria(): CriteriaWithLimitInterface
    {
        return new class implements CriteriaWithLimitInterface {
            use CriteriaWithLimitTrait;
        };
    }
}
