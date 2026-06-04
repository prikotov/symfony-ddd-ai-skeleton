<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Module\User\Application\UseCase\Query\UserProfile\ListUserProfiles;

use DateTimeImmutable;
use Override;
use PHPUnit\Framework\TestCase;
use Skeleton\Common\Application\Dto\PaginationDto;
use Skeleton\Common\Component\Repository\Enum\SortEnum;
use Skeleton\Common\Module\User\Application\UseCase\Query\UserProfile\ListUserProfiles\ListUserProfilesQuery;
use Skeleton\Common\Module\User\Application\UseCase\Query\UserProfile\ListUserProfiles\ListUserProfilesQueryHandler;
use Skeleton\Common\Module\User\Domain\Entity\UserProfileModel;
use Skeleton\Common\Module\User\Domain\Enum\UserProfileStatusEnum;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\Criteria\UserProfileFindCriteria;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\UserProfileCriteriaInterface;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\UserProfileRepositoryInterface;
use Skeleton\Common\Module\User\Domain\ValueObject\ContactEmailVo;
use Skeleton\Common\Module\User\Domain\ValueObject\DisplayNameVo;
use Symfony\Component\Uid\Uuid;

final class ListUserProfilesQueryHandlerTest extends TestCase
{
    public function testInvokeWithExplicitPaginationAndSortReturnsUserProfileListDto(): void
    {
        $userProfile = $this->createUserProfile(
            uuid: '01890f7a-0000-7000-8000-000000000001',
            displayName: 'Ada Lovelace',
            contactEmail: 'ada@example.com',
        );
        $repository = new UserProfileRepositoryStub([$userProfile], total: 10);
        $handler = new ListUserProfilesQueryHandler($repository);

        $result = $handler(new ListUserProfilesQuery(
            pagination: new PaginationDto(limit: 1, offset: 2),
            sort: ['displayName' => SortEnum::asc, 'uuid' => SortEnum::asc],
        ));

        self::assertSame(10, $result->total);
        self::assertCount(1, $result->items);
        self::assertSame('01890f7a-0000-7000-8000-000000000001', $result->items[0]->uuid);
        self::assertSame('Ada Lovelace', $result->items[0]->displayName);
        self::assertSame('ada@example.com', $result->items[0]->contactEmail);
        self::assertSame('published', $result->items[0]->status);

        self::assertInstanceOf(UserProfileFindCriteria::class, $repository->lastListCriteria);
        self::assertSame(1, $repository->lastListCriteria->getLimit());
        self::assertSame(2, $repository->lastListCriteria->getOffset());
        self::assertSame(
            ['displayName' => SortEnum::asc, 'uuid' => SortEnum::asc],
            $repository->lastListCriteria->getSort(),
        );
    }

    private function createUserProfile(
        string $uuid,
        string $displayName,
        string $contactEmail,
    ): UserProfileModel {
        return new UserProfileModel(
            uuid: Uuid::fromString($uuid),
            displayName: DisplayNameVo::createFromString($displayName),
            contactEmail: ContactEmailVo::createFromEmail($contactEmail),
            status: UserProfileStatusEnum::published,
            createdAt: new DateTimeImmutable('2026-06-02T00:00:00+00:00'),
        );
    }
}

final class UserProfileRepositoryStub implements UserProfileRepositoryInterface
{
    public ?UserProfileCriteriaInterface $lastListCriteria = null;

    /**
     * @param list<UserProfileModel> $items
     */
    public function __construct(
        private array $items,
        private int $total,
    ) {
    }

    #[Override]
    public function getById(?int $id = null, ?Uuid $uuid = null): UserProfileModel
    {
        unset($id, $uuid);

        return $this->items[0];
    }

    #[Override]
    public function getOneByCriteria(UserProfileCriteriaInterface $criteria): ?UserProfileModel
    {
        return $this->items[0] ?? null;
    }

    #[Override]
    public function getByCriteria(UserProfileCriteriaInterface $criteria): array
    {
        $this->lastListCriteria = $criteria;

        return $this->items;
    }

    #[Override]
    public function getCountByCriteria(UserProfileCriteriaInterface $criteria): int
    {
        return $this->total;
    }

    #[Override]
    public function save(UserProfileModel $userProfile): void
    {
        $this->items[] = $userProfile;
    }
}
