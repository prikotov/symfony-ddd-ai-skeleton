<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Domain\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Skeleton\Common\Component\Doctrine\Model\IdModelInterface;
use Skeleton\Common\Component\Doctrine\Model\InsTsModelInterface;
use Skeleton\Common\Component\Doctrine\Model\UuidModelInterface;
use Skeleton\Common\Component\Doctrine\Trait\IdTrait;
use Skeleton\Common\Component\Doctrine\Trait\InsTsTrait;
use Skeleton\Common\Component\Doctrine\Trait\UuidTrait;
use Skeleton\Common\Module\User\Domain\Enum\UserProfileStatusEnum;
use Skeleton\Common\Module\User\Domain\ValueObject\ContactEmailVo;
use Skeleton\Common\Module\User\Domain\ValueObject\DisplayNameVo;
use Symfony\Component\Uid\Uuid;

/**
 * Neutral user profile record for DDD/CQRS module examples.
 *
 * The model intentionally has no password, credential, role, login or registration data.
 */
#[ORM\Entity]
#[ORM\Table(name: 'user_profile')]
#[ORM\Index(name: 'i_user_profile__status', columns: ['status'])]
#[ORM\Index(name: 'i_user_profile__display_name', columns: ['display_name'])]
#[ORM\Index(name: 'i_user_profile__contact_email', columns: ['contact_email'])]
#[ORM\Index(name: 'i_user_profile__ins_ts', columns: ['ins_ts'])]
#[ORM\UniqueConstraint(name: 'ui_user_profile__uuid', columns: ['uuid'])]
class UserProfileModel implements IdModelInterface, UuidModelInterface, InsTsModelInterface
{
    use IdTrait;
    use UuidTrait;
    use InsTsTrait;

    #[ORM\Column(name: 'display_name', type: Types::STRING, length: DisplayNameVo::MAX_LENGTH)]
    private string $displayName;

    #[ORM\Column(name: 'contact_email', type: Types::STRING, length: ContactEmailVo::MAX_LENGTH)]
    private string $contactEmail;

    #[ORM\Column(type: Types::SMALLINT, enumType: UserProfileStatusEnum::class)]
    private UserProfileStatusEnum $status;

    public function __construct(
        Uuid $uuid,
        DisplayNameVo $displayName,
        ContactEmailVo $contactEmail,
        UserProfileStatusEnum $status,
        DateTimeImmutable $createdAt,
    ) {
        $this->uuid = $uuid;
        $this->displayName = $displayName->toString();
        $this->contactEmail = $contactEmail->toString();
        $this->status = $status;
        $this->insTs = $createdAt;
    }

    public function getDisplayName(): DisplayNameVo
    {
        return DisplayNameVo::createFromString($this->displayName);
    }

    public function rename(DisplayNameVo $displayName): void
    {
        $this->displayName = $displayName->toString();
    }

    public function getContactEmail(): ContactEmailVo
    {
        return ContactEmailVo::createFromEmail($this->contactEmail);
    }

    public function changeContactEmail(ContactEmailVo $contactEmail): void
    {
        $this->contactEmail = $contactEmail->toString();
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
        return $this->getInsTs();
    }
}
