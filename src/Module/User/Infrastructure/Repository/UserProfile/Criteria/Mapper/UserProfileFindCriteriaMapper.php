<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Infrastructure\Repository\UserProfile\Criteria\Mapper;

use Doctrine\ORM\QueryBuilder;
use Skeleton\Common\Component\Repository\Criteria\Mapper\LimitOffsetSortCriteriaMapper;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\Criteria\UserProfileFindCriteria;
use Skeleton\Common\Module\User\Infrastructure\Repository\UserProfile\UserProfileRepository;

final readonly class UserProfileFindCriteriaMapper
{
    private const string ALIAS = 'userProfile';

    /**
     * @var array<string, string>
     */
    private const array SORT_WHITELIST = [
        'contactEmail' => self::ALIAS . '.contactEmail',
        'createdAt' => self::ALIAS . '.insTs',
        'displayName' => self::ALIAS . '.displayName',
        'status' => self::ALIAS . '.status',
        'uuid' => self::ALIAS . '.uuid',
    ];

    public function __construct(
        private LimitOffsetSortCriteriaMapper $limitOffsetSortCriteriaMapper,
    ) {
    }

    public function map(UserProfileRepository $repository, UserProfileFindCriteria $criteria): QueryBuilder
    {
        $queryBuilder = $this->mapFilters($repository, $criteria);
        $queryBuilder->addCriteria($this->limitOffsetSortCriteriaMapper->map($criteria, self::SORT_WHITELIST));

        return $queryBuilder;
    }

    public function mapFilters(UserProfileRepository $repository, UserProfileFindCriteria $criteria): QueryBuilder
    {
        $queryBuilder = $repository->createQueryBuilder(self::ALIAS);

        $status = $criteria->getStatus();
        if ($status !== null) {
            $queryBuilder
                ->andWhere(self::ALIAS . '.status = :status')
                ->setParameter('status', $status);
        }

        $search = $criteria->getSearch();
        if ($search !== null) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->orX(
                    sprintf('%s.displayName LIKE :search', self::ALIAS),
                    sprintf('%s.contactEmail LIKE :search', self::ALIAS),
                ))
                ->setParameter('search', '%' . $search . '%');
        }

        return $queryBuilder;
    }
}
