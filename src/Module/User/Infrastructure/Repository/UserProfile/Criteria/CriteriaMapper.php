<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Infrastructure\Repository\UserProfile\Criteria;

use Doctrine\ORM\QueryBuilder;
use Skeleton\Common\Exception\ConfigurationException;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\Criteria\UserProfileFindCriteria;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\UserProfileCriteriaInterface;
use Skeleton\Common\Module\User\Infrastructure\Repository\UserProfile\Criteria\Mapper\UserProfileFindCriteriaMapper;
use Skeleton\Common\Module\User\Infrastructure\Repository\UserProfile\UserProfileRepository;

final readonly class CriteriaMapper
{
    public function __construct(
        private UserProfileFindCriteriaMapper $userProfileFindCriteriaMapper,
    ) {
    }

    public function map(UserProfileRepository $repository, UserProfileCriteriaInterface $criteria): QueryBuilder
    {
        return match ($criteria::class) {
            UserProfileFindCriteria::class => $this->userProfileFindCriteriaMapper->map($repository, $criteria),
            default => throw new ConfigurationException('Mapper not found for ' . $criteria::class),
        };
    }
}
