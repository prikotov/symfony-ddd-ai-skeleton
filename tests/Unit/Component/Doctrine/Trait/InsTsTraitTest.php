<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Component\Doctrine\Trait;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Skeleton\Common\Component\Doctrine\Model\InsTsModelInterface;
use Skeleton\Common\Component\Doctrine\Trait\InsTsTrait;
use ValueError;

final class InsTsTraitTest extends TestCase
{
    public function testGetInsTsReturnsAssignedInsertTimestamp(): void
    {
        $insTs = new DateTimeImmutable('2026-06-04T00:00:00+00:00');
        $model = new class($insTs) implements InsTsModelInterface {
            use InsTsTrait;

            public function __construct(DateTimeImmutable $insTs)
            {
                $this->insTs = $insTs;
            }
        };

        self::assertSame($insTs, $model->getInsTs());
    }

    public function testGetInsTsWhenUnsetThrowsValueError(): void
    {
        $model = new class implements InsTsModelInterface {
            use InsTsTrait;
        };

        self::expectException(ValueError::class);
        self::expectExceptionMessage('Entity insert timestamp is not set.');

        $model->getInsTs();
    }
}
