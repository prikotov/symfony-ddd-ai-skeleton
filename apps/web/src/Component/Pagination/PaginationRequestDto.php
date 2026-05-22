<?php

declare(strict_types=1);

namespace Skeleton\Web\Component\Pagination;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class PaginationRequestDto
{
    public function __construct(
        #[Assert\Positive]
        public int $page = 1,
        #[Assert\Positive]
        public int $perPage = 10,
    ) {
    }
}
