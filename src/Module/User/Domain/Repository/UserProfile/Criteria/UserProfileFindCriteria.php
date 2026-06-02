<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Domain\Repository\UserProfile\Criteria;

use Skeleton\Common\Component\Repository\CriteriaWithLimitInterface;
use Skeleton\Common\Component\Repository\CriteriaWithOffsetInterface;
use Skeleton\Common\Component\Repository\SortableCriteriaInterface;
use Skeleton\Common\Component\Repository\Trait\CriteriaWithLimitTrait;
use Skeleton\Common\Component\Repository\Trait\CriteriaWithOffsetTrait;
use Skeleton\Common\Component\Repository\Trait\SortableCriteriaTrait;
use Skeleton\Common\Module\User\Domain\Enum\UserProfileStatusEnum;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\UserProfileCriteriaInterface;

final class UserProfileFindCriteria implements
    UserProfileCriteriaInterface,
    SortableCriteriaInterface,
    CriteriaWithLimitInterface,
    CriteriaWithOffsetInterface
{
    use SortableCriteriaTrait;
    use CriteriaWithLimitTrait;
    use CriteriaWithOffsetTrait;

    public function __construct(
        private ?string $search = null,
        private ?UserProfileStatusEnum $status = null,
    ) {
        $this->setSearch($search);
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): void
    {
        $normalized = $search === null ? null : strtolower(trim($search));
        $this->search = $normalized === '' ? null : $normalized;
    }

    public function getStatus(): ?UserProfileStatusEnum
    {
        return $this->status;
    }

    public function setStatus(?UserProfileStatusEnum $status): void
    {
        $this->status = $status;
    }
}
