<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Domain\Repository\UserProfile;

use Skeleton\Common\Module\User\Domain\Entity\UserProfileModel;
use Symfony\Component\Uid\Uuid;

/**
 * Domain repository contract for neutral user profile examples.
 */
interface UserProfileRepositoryInterface
{
    public function getByUuid(Uuid $uuid): ?UserProfileModel;

    public function getOneByCriteria(UserProfileCriteriaInterface $criteria): ?UserProfileModel;

    /**
     * @return list<UserProfileModel>
     */
    public function getByCriteria(UserProfileCriteriaInterface $criteria): array;

    public function getCountByCriteria(UserProfileCriteriaInterface $criteria): int;

    public function save(UserProfileModel $userProfile): void;
}
