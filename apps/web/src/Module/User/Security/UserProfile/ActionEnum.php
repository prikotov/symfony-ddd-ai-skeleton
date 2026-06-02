<?php

declare(strict_types=1);

namespace Skeleton\Web\Module\User\Security\UserProfile;

enum ActionEnum: string
{
    case listProfiles = 'user.user_profile.list';
}
