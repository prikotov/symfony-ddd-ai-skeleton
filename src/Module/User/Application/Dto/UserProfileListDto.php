<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Application\Dto;

final readonly class UserProfileListDto
{
    /**
     * @param list<UserProfileDto> $items
     */
    public function __construct(
        public array $items,
        public int $total,
    ) {
    }
}
