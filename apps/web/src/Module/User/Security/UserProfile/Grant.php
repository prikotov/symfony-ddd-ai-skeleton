<?php

declare(strict_types=1);

namespace Skeleton\Web\Module\User\Security\UserProfile;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final readonly class Grant
{
    public function __construct(
        private AuthorizationCheckerInterface $authorizationChecker,
    ) {
    }

    public function canList(): bool
    {
        return $this->authorizationChecker->isGranted(ActionEnum::listProfiles->value, null);
    }
}
