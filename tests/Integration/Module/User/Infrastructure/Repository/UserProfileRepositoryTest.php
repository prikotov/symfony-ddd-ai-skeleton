<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Integration\Module\User\Infrastructure\Repository;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use InvalidArgumentException;
use Override;
use Skeleton\Common\Component\Repository\Enum\SortEnum;
use Skeleton\Common\Kernel;
use Skeleton\Common\Module\User\Domain\Entity\UserProfileModel;
use Skeleton\Common\Module\User\Domain\Enum\UserProfileStatusEnum;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\Criteria\UserProfileFindCriteria;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\UserProfileRepositoryInterface;
use Skeleton\Common\Module\User\Domain\ValueObject\ContactEmailVo;
use Skeleton\Common\Module\User\Domain\ValueObject\DisplayNameVo;
use Skeleton\Common\Module\User\Infrastructure\Repository\UserProfile\UserProfileRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Uid\Uuid;

final class UserProfileRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;

    private UserProfileRepositoryInterface $repository;

    #[Override]
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $container = $kernel->getContainer();
        $entityManager = $container->get(EntityManagerInterface::class);
        $repository = $container->get(UserProfileRepositoryInterface::class);

        self::assertInstanceOf(EntityManagerInterface::class, $entityManager);
        self::assertInstanceOf(UserProfileRepository::class, $repository);

        $this->entityManager = $entityManager;
        $this->repository = $repository;

        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->createSchema([$this->entityManager->getClassMetadata(UserProfileModel::class)]);

        $this->seedUserProfiles();
    }

    #[Override]
    protected function tearDown(): void
    {
        if (isset($this->entityManager)) {
            $schemaTool = new SchemaTool($this->entityManager);
            $schemaTool->dropSchema([$this->entityManager->getClassMetadata(UserProfileModel::class)]);
            $this->entityManager->close();
        }

        parent::tearDown();
    }

    public function testGetByUuidReturnsPersistedUserProfile(): void
    {
        $uuid = Uuid::fromString('01890f7a-0000-7000-8000-000000000002');

        $userProfile = $this->repository->getByUuid($uuid);

        self::assertInstanceOf(UserProfileModel::class, $userProfile);
        self::assertGreaterThan(0, $userProfile->getId());
        self::assertSame('Ada Lovelace', $userProfile->getDisplayName()->toString());
        self::assertSame('2026-06-02 00:00:00', $userProfile->getInsTs()->format('Y-m-d H:i:s'));
    }

    public function testGetByCriteriaFiltersBySearchAndStatus(): void
    {
        $criteria = new UserProfileFindCriteria(
            search: 'Ada',
            status: UserProfileStatusEnum::published,
        );

        $result = $this->repository->getByCriteria($criteria);

        self::assertCount(1, $result);
        self::assertSame('Ada Lovelace', $result[0]->getDisplayName()->toString());
    }

    public function testGetByCriteriaWithoutSortReturnsAllMatchingProfiles(): void
    {
        $criteria = new UserProfileFindCriteria();

        $result = $this->repository->getByCriteria($criteria);
        $displayNames = array_map(
            static fn(UserProfileModel $userProfile): string => $userProfile->getDisplayName()->toString(),
            $result,
        );

        self::assertCount(3, $result);
        self::assertContains('Grace Hopper', $displayNames);
        self::assertContains('Ada Lovelace', $displayNames);
        self::assertContains('Katherine Johnson', $displayNames);
    }

    public function testGetByCriteriaAppliesExplicitSortLimitAndOffset(): void
    {
        $criteria = new UserProfileFindCriteria(status: UserProfileStatusEnum::published);
        $criteria->setSort(['displayName' => SortEnum::asc, 'uuid' => SortEnum::asc]);
        $criteria->setOffset(1);
        $criteria->setLimit(1);

        $result = $this->repository->getByCriteria($criteria);

        self::assertCount(1, $result);
        self::assertSame('Grace Hopper', $result[0]->getDisplayName()->toString());
    }

    public function testGetByCriteriaMapsCreatedAtSortToInsertTimestamp(): void
    {
        $criteria = new UserProfileFindCriteria(status: UserProfileStatusEnum::published);
        $criteria->setSort(['createdAt' => SortEnum::asc, 'uuid' => SortEnum::asc]);

        $result = $this->repository->getByCriteria($criteria);

        self::assertCount(2, $result);
        self::assertSame('Ada Lovelace', $result[0]->getDisplayName()->toString());
        self::assertSame('Grace Hopper', $result[1]->getDisplayName()->toString());
    }

    public function testGetCountByCriteriaIgnoresLimitAndOffset(): void
    {
        $criteria = new UserProfileFindCriteria(status: UserProfileStatusEnum::published);
        $criteria->setOffset(1);
        $criteria->setLimit(1);

        self::assertSame(2, $this->repository->getCountByCriteria($criteria));
    }

    public function testGetByCriteriaRejectsUnknownSortField(): void
    {
        $criteria = new UserProfileFindCriteria();
        $criteria->setSort(['password' => SortEnum::asc]);

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Sort field "password" is not in the allowed list.');

        $this->repository->getByCriteria($criteria);
    }

    private function seedUserProfiles(): void
    {
        foreach ([
            $this->createUserProfile(
                uuid: '01890f7a-0000-7000-8000-000000000001',
                displayName: 'Grace Hopper',
                contactEmail: 'grace@example.com',
                status: UserProfileStatusEnum::published,
                createdAt: '2026-06-02T00:00:01+00:00',
            ),
            $this->createUserProfile(
                uuid: '01890f7a-0000-7000-8000-000000000002',
                displayName: 'Ada Lovelace',
                contactEmail: 'ada@example.com',
                status: UserProfileStatusEnum::published,
                createdAt: '2026-06-02T00:00:00+00:00',
            ),
            $this->createUserProfile(
                uuid: '01890f7a-0000-7000-8000-000000000003',
                displayName: 'Katherine Johnson',
                contactEmail: 'katherine@example.com',
                status: UserProfileStatusEnum::archived,
                createdAt: '2026-06-02T00:00:02+00:00',
            ),
        ] as $userProfile) {
            $this->repository->save($userProfile);
        }

        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    private function createUserProfile(
        string $uuid,
        string $displayName,
        string $contactEmail,
        UserProfileStatusEnum $status,
        string $createdAt,
    ): UserProfileModel {
        return new UserProfileModel(
            uuid: Uuid::fromString($uuid),
            displayName: DisplayNameVo::createFromString($displayName),
            contactEmail: ContactEmailVo::createFromEmail($contactEmail),
            status: $status,
            createdAt: new DateTimeImmutable($createdAt),
        );
    }

    #[Override]
    protected static function createKernel(array $options = []): KernelInterface
    {
        $_SERVER['APP_ENV'] = 'test';
        $_SERVER['APP_DEBUG'] = '1';
        $_SERVER['APP_SECRET'] = 'test';
        $_SERVER['DATABASE_URL'] = 'sqlite:///:memory:';
        $_SERVER['APP_CACHE_DIR'] = sys_get_temp_dir() . '/skeleton-tests/cache-user-profile-repository';
        $_SERVER['APP_LOG_DIR'] = sys_get_temp_dir() . '/skeleton-tests/log-user-profile-repository';

        return new Kernel('test', true, 'console');
    }
}
