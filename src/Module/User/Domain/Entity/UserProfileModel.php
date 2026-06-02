<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Domain\Entity;

use DateTimeImmutable;
use Skeleton\Common\Module\User\Domain\Enum\UserProfileStatusEnum;
use Skeleton\Common\Module\User\Domain\ValueObject\ContactEmailVo;
use Skeleton\Common\Module\User\Domain\ValueObject\DisplayNameVo;
use Symfony\Component\Uid\Uuid;

/**
 * Neutral user profile record for DDD/CQRS module examples.
 *
 * The model intentionally has no password, credential, role, login or registration data.
 */
final class UserProfileModel
{
    public function __construct(
        private readonly Uuid $uuid,
        private DisplayNameVo $displayName,
        private ContactEmailVo $contactEmail,
        private UserProfileStatusEnum $status,
        private readonly DateTimeImmutable $createdAt,
    ) {
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getDisplayName(): DisplayNameVo
    {
        return $this->displayName;
    }

    public function rename(DisplayNameVo $displayName): void
    {
        $this->displayName = $displayName;
    }

    public function getContactEmail(): ContactEmailVo
    {
        return $this->contactEmail;
    }

    public function changeContactEmail(ContactEmailVo $contactEmail): void
    {
        $this->contactEmail = $contactEmail;
    }

    public function getStatus(): UserProfileStatusEnum
    {
        return $this->status;
    }

    public function publish(): void
    {
        $this->status = UserProfileStatusEnum::published;
    }

    public function archive(): void
    {
        $this->status = UserProfileStatusEnum::archived;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
