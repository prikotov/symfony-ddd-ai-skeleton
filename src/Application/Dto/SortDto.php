<?php

declare(strict_types=1);

namespace Skeleton\Common\Application\Dto;

use Skeleton\Common\Application\Enum\SortDirectionEnum;

final readonly class SortDto
{
    /**
     * @param array<string, SortDirectionEnum> $order [attribute => sort direction]
     */
    public function __construct(
        public array $order,
    ) {
    }
}
