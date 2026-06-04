<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Domain\Enum;

/**
 * Neutral lifecycle state for the skeleton user profile example.
 *
 * This enum is not an authentication, authorization or account-lock state.
 */
enum UserProfileStatusEnum: int
{
    case draft = 1;
    case published = 2;
    case archived = 3;
}
