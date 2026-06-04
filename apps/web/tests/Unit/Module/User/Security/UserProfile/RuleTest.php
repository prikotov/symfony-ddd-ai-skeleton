<?php

declare(strict_types=1);

namespace Skeleton\Web\Test\Unit\Module\User\Security\UserProfile;

use PHPUnit\Framework\TestCase;
use Skeleton\Web\Module\User\Security\UserProfile\PermissionEnum;
use Skeleton\Web\Module\User\Security\UserProfile\Rule;
use Symfony\Component\Security\Core\Role\RoleHierarchy;

final class RuleTest extends TestCase
{
    public function testCanListWithDirectPermissionReturnsTrue(): void
    {
        $rule = new Rule(new RoleHierarchy([]));
        $token = new TokenStub([PermissionEnum::viewProfiles->value]);

        self::assertTrue($rule->canList($token));
    }

    public function testCanListWithMappedPermissionReturnsTrue(): void
    {
        $roleName = 'project.local_profile_reader';
        $rule = new Rule(new RoleHierarchy([
            $roleName => [PermissionEnum::viewProfiles->value],
        ]));
        $token = new TokenStub([$roleName]);

        self::assertTrue($rule->canList($token));
    }

    public function testCanListWithoutPermissionReturnsFalse(): void
    {
        $rule = new Rule(new RoleHierarchy([]));
        $token = new TokenStub([]);

        self::assertFalse($rule->canList($token));
    }
}
