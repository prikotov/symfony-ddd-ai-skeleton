<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Application\Dto;

use DateTimeImmutable;

/**
 * Application DTO for a neutral user profile record.
 */
final readonly class UserProfileDto
{
    public function __construct(
        public string $uuid,
        public string $displayName,
        public string $contactEmail,
        public string $status,
        public DateTimeImmutable $createdAt,
    ) {
    }
}
