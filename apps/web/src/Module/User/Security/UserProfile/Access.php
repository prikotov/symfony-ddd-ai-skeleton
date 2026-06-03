<?php

declare(strict_types=1);

namespace Skeleton\Web\Module\User\Security\UserProfile;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Presentation helper for UI visibility checks.
 *
 * It is intentionally a thin facade over Symfony authorization: actual decisions stay in {@see Rule},
 * and controllers still use {@see Voter} through #[IsGranted].
 */
final readonly class Access
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
