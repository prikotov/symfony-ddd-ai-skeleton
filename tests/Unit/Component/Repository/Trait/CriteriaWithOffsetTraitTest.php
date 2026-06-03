<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Component\Repository\Trait;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Skeleton\Common\Component\Repository\CriteriaWithOffsetInterface;
use Skeleton\Common\Component\Repository\Trait\CriteriaWithOffsetTrait;

final class CriteriaWithOffsetTraitTest extends TestCase
{
    public function testSetOffsetAcceptsZeroOffset(): void
    {
        $criteria = $this->createCriteria();

        $criteria->setOffset(0);

        self::assertSame(0, $criteria->getOffset());
    }

    public function testSetOffsetAcceptsPositiveOffset(): void
    {
        $criteria = $this->createCriteria();

        $criteria->setOffset(10);

        self::assertSame(10, $criteria->getOffset());
    }

    public function testSetOffsetRejectsNegativeOffset(): void
    {
        $criteria = $this->createCriteria();

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Criteria offset must not be negative.');

        $criteria->setOffset(-1);
    }

    private function createCriteria(): CriteriaWithOffsetInterface
    {
        return new class implements CriteriaWithOffsetInterface {
            use CriteriaWithOffsetTrait;
        };
    }
}
