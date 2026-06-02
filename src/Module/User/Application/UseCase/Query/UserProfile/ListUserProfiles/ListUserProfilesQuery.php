<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Application\UseCase\Query\UserProfile\ListUserProfiles;

use Skeleton\Common\Application\Dto\PaginationDto;
use Skeleton\Common\Application\Query\QueryInterface;
use Skeleton\Common\Component\Repository\Enum\SortEnum;
use Skeleton\Common\Module\User\Application\Dto\UserProfileListDto;

/**
 * Lists neutral user profiles with caller-provided pagination and sort.
 *
 * No default pagination, default users or implicit sort are applied by this query.
 *
 * @implements QueryInterface<UserProfileListDto>
 */
final readonly class ListUserProfilesQuery implements QueryInterface
{
    /**
     * @param array<string, SortEnum> $sort
     */
    public function __construct(
        public ?PaginationDto $pagination,
        public array $sort,
    ) {
    }
}
