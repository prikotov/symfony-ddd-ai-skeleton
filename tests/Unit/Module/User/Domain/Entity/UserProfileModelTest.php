<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Module\User\Domain\Entity;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Skeleton\Common\Module\User\Domain\Entity\UserProfileModel;
use Skeleton\Common\Module\User\Domain\Enum\UserProfileStatusEnum;
use Skeleton\Common\Module\User\Domain\ValueObject\ContactEmailVo;
use Skeleton\Common\Module\User\Domain\ValueObject\DisplayNameVo;
use Symfony\Component\Uid\Uuid;

final class UserProfileModelTest extends TestCase
{
    public function testConstructorWithNeutralProfileDataProvidesAccessors(): void
    {
        $uuid = Uuid::fromString('01890f7a-0000-7000-8000-000000000001');
        $createdAt = new DateTimeImmutable('2026-06-02T00:00:00+00:00');

        $userProfile = new UserProfileModel(
            uuid: $uuid,
            displayName: DisplayNameVo::createFromString('Ada Lovelace'),
            contactEmail: ContactEmailVo::createFromEmail('ada@example.com'),
            status: UserProfileStatusEnum::draft,
            createdAt: $createdAt,
        );

        self::assertSame($uuid, $userProfile->getUuid());
        self::assertSame('Ada Lovelace', $userProfile->getDisplayName()->toString());
        self::assertSame('ada@example.com', $userProfile->getContactEmail()->toString());
        self::assertSame(UserProfileStatusEnum::draft, $userProfile->getStatus());
        self::assertSame($createdAt, $userProfile->getCreatedAt());
    }

    public function testRenameAndChangeContactEmailUpdateProfileFields(): void
    {
        $userProfile = $this->createUserProfile();

        $userProfile->rename(DisplayNameVo::createFromString('Grace Hopper'));
        $userProfile->changeContactEmail(ContactEmailVo::createFromEmail('grace@example.com'));

        self::assertSame('Grace Hopper', $userProfile->getDisplayName()->toString());
        self::assertSame('grace@example.com', $userProfile->getContactEmail()->toString());
    }

    public function testPublishAndArchiveChangeNeutralLifecycleStatus(): void
    {
        $userProfile = $this->createUserProfile();

        $userProfile->publish();
        self::assertSame(UserProfileStatusEnum::published, $userProfile->getStatus());

        $userProfile->archive();
        self::assertSame(UserProfileStatusEnum::archived, $userProfile->getStatus());
    }

    private function createUserProfile(): UserProfileModel
    {
        return new UserProfileModel(
            uuid: Uuid::fromString('01890f7a-0000-7000-8000-000000000001'),
            displayName: DisplayNameVo::createFromString('Ada Lovelace'),
            contactEmail: ContactEmailVo::createFromEmail('ada@example.com'),
            status: UserProfileStatusEnum::draft,
            createdAt: new DateTimeImmutable('2026-06-02T00:00:00+00:00'),
        );
    }
}
