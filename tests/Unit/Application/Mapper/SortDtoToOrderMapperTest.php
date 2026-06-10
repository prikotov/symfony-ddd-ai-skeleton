<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Application\Mapper;

use PHPUnit\Framework\TestCase;
use Skeleton\Common\Application\Dto\SortDto;
use Skeleton\Common\Application\Enum\SortDirectionEnum;
use Skeleton\Common\Application\Mapper\SortDtoToOrderMapper;
use Skeleton\Common\Component\Repository\Enum\SortEnum;

final class SortDtoToOrderMapperTest extends TestCase
{
    public function testMapsApplicationSortDtoToRepositoryOrder(): void
    {
        $mapper = new SortDtoToOrderMapper();

        $order = $mapper->map(new SortDto([
            'displayName' => SortDirectionEnum::asc,
            'createdAt' => SortDirectionEnum::desc,
        ]));

        self::assertSame([
            'displayName' => SortEnum::asc,
            'createdAt' => SortEnum::desc,
        ], $order);
    }

    public function testMapsAttributeNames(): void
    {
        $mapper = new SortDtoToOrderMapper();

        $order = $mapper->map(
            new SortDto(['displayName' => SortDirectionEnum::asc]),
            ['displayName' => 'name'],
        );

        self::assertSame(['name' => SortEnum::asc], $order);
    }
}
