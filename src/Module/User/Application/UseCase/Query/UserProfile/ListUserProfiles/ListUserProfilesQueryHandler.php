<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Application\UseCase\Query\UserProfile\ListUserProfiles;

use Skeleton\Common\Module\User\Application\Dto\UserProfileDto;
use Skeleton\Common\Module\User\Application\Dto\UserProfileListDto;
use Skeleton\Common\Module\User\Domain\Entity\UserProfileModel;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\Criteria\UserProfileFindCriteria;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\UserProfileRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ListUserProfilesQueryHandler
{
    public function __construct(
        private UserProfileRepositoryInterface $userProfiles,
    ) {
    }

    public function __invoke(ListUserProfilesQuery $query): UserProfileListDto
    {
        $criteria = new UserProfileFindCriteria();
        $total = $this->userProfiles->getCountByCriteria($criteria);

        if ($query->pagination !== null) {
            $criteria->setLimit($query->pagination->limit);
            $criteria->setOffset($query->pagination->offset);
        }

        $criteria->setSort($query->sort);

        $items = [];
        foreach ($this->userProfiles->getByCriteria($criteria) as $userProfile) {
            $items[] = $this->mapUserProfile($userProfile);
        }

        return new UserProfileListDto(
            items: $items,
            total: $total,
        );
    }

    private function mapUserProfile(UserProfileModel $userProfile): UserProfileDto
    {
        return new UserProfileDto(
            uuid: $userProfile->getUuid()->toRfc4122(),
            displayName: $userProfile->getDisplayName()->toString(),
            contactEmail: $userProfile->getContactEmail()->toString(),
            status: $userProfile->getStatus()->name,
            createdAt: $userProfile->getCreatedAt(),
        );
    }
}
