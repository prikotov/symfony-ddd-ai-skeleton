<?php

declare(strict_types=1);

namespace Skeleton\Common\Application\Dto;

final readonly class PaginationDto
{
    public function __construct(
        public int $limit,
        public int $offset = 0,
    ) {
    }
}
