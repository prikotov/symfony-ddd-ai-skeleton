<?php

declare(strict_types=1);

namespace Skeleton\Web\Test\Unit\Component\Sort;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Skeleton\Common\Application\Dto\SortDto;
use Skeleton\Common\Application\Enum\SortDirectionEnum;
use Skeleton\Web\Component\Sort\SortRequestDto;
use Skeleton\Web\Component\Sort\SortRequestToApplicationDtoMapper;

final class SortRequestToApplicationDtoMapperTest extends TestCase
{
    public function testReturnsNullWhenSortAndDefaultSortAreMissing(): void
    {
        $mapper = new SortRequestToApplicationDtoMapper();

        self::assertNull($mapper->map(new SortRequestDto()));
    }

    public function testMapsAscendingSort(): void
    {
        $mapper = new SortRequestToApplicationDtoMapper();

        $sort = $mapper->map(new SortRequestDto(sort: 'displayName'), allowedSorts: ['displayName']);

        self::assertInstanceOf(SortDto::class, $sort);
        self::assertSame(['displayName' => SortDirectionEnum::asc], $sort->order);
    }

    public function testMapsDescendingSort(): void
    {
        $mapper = new SortRequestToApplicationDtoMapper();

        $sort = $mapper->map(new SortRequestDto(sort: '-createdAt'), allowedSorts: ['createdAt']);

        self::assertInstanceOf(SortDto::class, $sort);
        self::assertSame(['createdAt' => SortDirectionEnum::desc], $sort->order);
    }

    public function testUsesDefaultSortWhenRequestSortIsMissing(): void
    {
        $mapper = new SortRequestToApplicationDtoMapper();

        $sort = $mapper->map(
            new SortRequestDto(),
            defaultSort: '-createdAt',
            allowedSorts: ['createdAt'],
        );

        self::assertInstanceOf(SortDto::class, $sort);
        self::assertSame(['createdAt' => SortDirectionEnum::desc], $sort->order);
    }

    public function testRejectsInvalidSortFormat(): void
    {
        $mapper = new SortRequestToApplicationDtoMapper();

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Invalid sort attribute format.');

        $mapper->map(new SortRequestDto(sort: 'display.name'), allowedSorts: ['displayName']);
    }

    public function testRejectsSortOutsideWhitelist(): void
    {
        $mapper = new SortRequestToApplicationDtoMapper();

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Sort attribute "email" is not allowed. Allowed: [displayName].');

        $mapper->map(new SortRequestDto(sort: 'email'), allowedSorts: ['displayName']);
    }
}
