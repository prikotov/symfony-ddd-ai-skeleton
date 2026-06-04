<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Infrastructure\Repository\UserProfile;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Override;
use Skeleton\Common\Exception\InfrastructureException;
use Skeleton\Common\Module\User\Domain\Entity\UserProfileModel;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\UserProfileCriteriaInterface;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\UserProfileRepositoryInterface;
use Skeleton\Common\Module\User\Infrastructure\Repository\UserProfile\Criteria\CriteriaMapper;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

/**
 * Doctrine Infrastructure repository for the neutral UserProfile example.
 *
 * The repository persists only profile data. It intentionally does not add credentials, default users or authentication
 * data to the skeleton.
 *
 * @extends ServiceEntityRepository<UserProfileModel>
 */
final class UserProfileRepository extends ServiceEntityRepository implements UserProfileRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly CriteriaMapper $criteriaMapper,
    ) {
        parent::__construct($registry, UserProfileModel::class);
    }

    #[Override]
    public function getByUuid(Uuid $uuid): ?UserProfileModel
    {
        /** @var UserProfileModel|null $userProfile */
        $userProfile = $this
            ->createQueryBuilder('userProfile')
            ->andWhere('userProfile.uuid = :uuid')
            ->setParameter('uuid', $uuid, UuidType::NAME)
            ->getQuery()
            ->getOneOrNullResult();

        return $userProfile;
    }

    #[Override]
    public function getOneByCriteria(UserProfileCriteriaInterface $criteria): ?UserProfileModel
    {
        /** @var UserProfileModel|null $userProfile */
        $userProfile = $this
            ->getQueryBuilderByCriteria($criteria)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $userProfile;
    }

    /**
     * @return list<UserProfileModel>
     */
    #[Override]
    public function getByCriteria(UserProfileCriteriaInterface $criteria): array
    {
        /** @var list<UserProfileModel> $userProfiles */
        $userProfiles = $this
            ->getQueryBuilderByCriteria($criteria)
            ->getQuery()
            ->getResult();

        return $userProfiles;
    }

    #[Override]
    public function getCountByCriteria(UserProfileCriteriaInterface $criteria): int
    {
        $queryBuilder = $this->getQueryBuilderByCriteria($criteria);
        $alias = $queryBuilder->getRootAliases()[0];

        $queryBuilder
            ->select(sprintf('COUNT(%s.id)', $alias))
            ->resetDQLPart('orderBy')
            ->setFirstResult(0)
            ->setMaxResults(null);

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }

    #[Override]
    public function save(UserProfileModel $userProfile): void
    {
        $this->getEntityManager()->persist($userProfile);
    }

    private function getQueryBuilderByCriteria(UserProfileCriteriaInterface $criteria): QueryBuilder
    {
        try {
            return $this->criteriaMapper->map($this, $criteria);
        } catch (QueryException $exception) {
            throw new InfrastructureException(
                message: sprintf('Failed to build query for %s: %s', $this->getEntityName(), $exception->getMessage()),
                previous: $exception,
            );
        }
    }
}
