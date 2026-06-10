<?php

declare(strict_types=1);

namespace Skeleton\Common\Application\Mapper;

use Skeleton\Common\Application\Dto\SortDto;
use Skeleton\Common\Application\Enum\SortDirectionEnum;
use Skeleton\Common\Component\Repository\Enum\SortEnum;

final readonly class SortDtoToOrderMapper
{
    /**
     * @param array<string, string> $attributesMap
     *
     * @return array<string, SortEnum>
     */
    public function map(
        SortDto $sort,
        array $attributesMap = [],
    ): array {
        $order = [];
        foreach ($sort->order as $attribute => $direction) {
            $order[$attributesMap[$attribute] ?? $attribute] = $this->mapDirection($direction);
        }

        return $order;
    }

    private function mapDirection(SortDirectionEnum $sortDirection): SortEnum
    {
        return match ($sortDirection) {
            SortDirectionEnum::asc => SortEnum::asc,
            SortDirectionEnum::desc => SortEnum::desc,
        };
    }
}
