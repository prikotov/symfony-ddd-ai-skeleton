<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Integration\Module\User\Infrastructure\Repository;

use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Skeleton\Common\Component\Repository\Enum\SortEnum;
use Skeleton\Common\Module\User\Domain\Entity\UserProfileModel;
use Skeleton\Common\Module\User\Domain\Enum\UserProfileStatusEnum;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\Criteria\UserProfileFindCriteria;
use Skeleton\Common\Module\User\Domain\ValueObject\ContactEmailVo;
use Skeleton\Common\Module\User\Domain\ValueObject\DisplayNameVo;
use Skeleton\Common\Module\User\Infrastructure\Repository\UserProfile\InMemoryUserProfileRepository;
use Symfony\Component\Uid\Uuid;

final class InMemoryUserProfileRepositoryTest extends TestCase
{
    public function testGetByUuidReturnsSavedUserProfile(): void
    {
        $repository = $this->createRepository();
        $uuid = Uuid::fromString('01890f7a-0000-7000-8000-000000000002');

        $userProfile = $repository->getByUuid($uuid);

        self::assertInstanceOf(UserProfileModel::class, $userProfile);
        self::assertSame('Ada Lovelace', $userProfile->getDisplayName()->toString());
    }

    public function testGetByCriteriaFiltersBySearchAndStatus(): void
    {
        $repository = $this->createRepository();
        $criteria = new UserProfileFindCriteria(
            search: 'ada',
            status: UserProfileStatusEnum::published,
        );

        $result = $repository->getByCriteria($criteria);

        self::assertCount(1, $result);
        self::assertSame('Ada Lovelace', $result[0]->getDisplayName()->toString());
    }

    public function testGetByCriteriaWithoutSortDoesNotApplyHiddenDefaultOrdering(): void
    {
        $repository = $this->createRepository();
        $criteria = new UserProfileFindCriteria();

        $result = $repository->getByCriteria($criteria);

        self::assertSame('Grace Hopper', $result[0]->getDisplayName()->toString());
        self::assertSame('Ada Lovelace', $result[1]->getDisplayName()->toString());
        self::assertSame('Katherine Johnson', $result[2]->getDisplayName()->toString());
    }

    public function testGetByCriteriaAppliesExplicitSortLimitAndOffset(): void
    {
        $repository = $this->createRepository();
        $criteria = new UserProfileFindCriteria(status: UserProfileStatusEnum::published);
        $criteria->setSort(['displayName' => SortEnum::asc, 'uuid' => SortEnum::asc]);
        $criteria->setOffset(1);
        $criteria->setLimit(1);

        $result = $repository->getByCriteria($criteria);

        self::assertCount(1, $result);
        self::assertSame('Grace Hopper', $result[0]->getDisplayName()->toString());
    }

    public function testGetCountByCriteriaIgnoresLimitAndOffset(): void
    {
        $repository = $this->createRepository();
        $criteria = new UserProfileFindCriteria(status: UserProfileStatusEnum::published);
        $criteria->setOffset(1);
        $criteria->setLimit(1);

        self::assertSame(2, $repository->getCountByCriteria($criteria));
    }

    public function testGetByCriteriaRejectsUnknownSortField(): void
    {
        $repository = $this->createRepository();
        $criteria = new UserProfileFindCriteria();
        $criteria->setSort(['password' => SortEnum::asc]);

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Sort field "password" is not in the allowed list.');

        $repository->getByCriteria($criteria);
    }

    private function createRepository(): InMemoryUserProfileRepository
    {
        return new InMemoryUserProfileRepository([
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
        ]);
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
}
