<?php

declare(strict_types=1);

namespace Skeleton\Web\Module\User\Security\UserProfile;

/**
 * Presentation permission values for the neutral UserProfile example.
 *
 * The skeleton does not map this enum to default roles or users; projects should wire it to their own auth model.
 */
enum PermissionEnum: string
{
    case viewProfiles = 'user.user_profile.viewProfiles';
}
