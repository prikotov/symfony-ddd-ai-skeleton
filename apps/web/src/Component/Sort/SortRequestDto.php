<?php

declare(strict_types=1);

namespace Skeleton\Web\Component\Sort;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class SortRequestDto
{
    public function __construct(
        #[Assert\NotBlank(allowNull: true)]
        public ?string $sort = null,
    ) {
    }
}
