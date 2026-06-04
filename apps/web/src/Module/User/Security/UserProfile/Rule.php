<?php

declare(strict_types=1);

namespace Skeleton\Web\Module\User\Security\UserProfile;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

/**
 * Presentation-only access rule for the neutral user profile list.
 *
 * It checks permissions from the Symfony security token and does not enforce Domain invariants.
 */
final readonly class Rule
{
    public function __construct(
        private RoleHierarchyInterface $roleHierarchy,
    ) {
    }

    public function canList(TokenInterface $token): bool
    {
        return $this->hasPermission(PermissionEnum::viewProfiles, $token);
    }

    private function hasPermission(PermissionEnum $permission, TokenInterface $token): bool
    {
        return in_array(
            $permission->value,
            $this->roleHierarchy->getReachableRoleNames($token->getRoleNames()),
            true,
        );
    }
}
