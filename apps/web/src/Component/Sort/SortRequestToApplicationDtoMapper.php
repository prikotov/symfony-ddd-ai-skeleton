<?php

declare(strict_types=1);

namespace Skeleton\Web\Component\Sort;

use InvalidArgumentException;
use Skeleton\Common\Application\Dto\SortDto;
use Skeleton\Common\Application\Enum\SortDirectionEnum;

final readonly class SortRequestToApplicationDtoMapper
{
    /**
     * @param list<string> $allowedSorts
     */
    public function map(
        SortRequestDto $sortRequest,
        ?string $defaultSort = null,
        array $allowedSorts = [],
    ): ?SortDto {
        $sort = $sortRequest->sort ?? $defaultSort;

        if ($sort === null) {
            return null;
        }

        if (!preg_match('/^(?P<order>-?)(?P<attribute>[a-zA-Z0-9_]+)$/u', $sort, $matches)) {
            throw new InvalidArgumentException('Invalid sort attribute format.');
        }

        $attribute = $matches['attribute'];
        if (!in_array($attribute, $allowedSorts, true)) {
            throw new InvalidArgumentException(sprintf(
                'Sort attribute "%s" is not allowed. Allowed: [%s].',
                $attribute,
                implode(', ', $allowedSorts),
            ));
        }

        $direction = $matches['order'] === '-' ? SortDirectionEnum::desc : SortDirectionEnum::asc;

        return new SortDto([
            $attribute => $direction,
        ]);
    }
}
