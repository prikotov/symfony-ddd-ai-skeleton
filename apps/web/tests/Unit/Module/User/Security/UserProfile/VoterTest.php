<?php

declare(strict_types=1);

namespace Skeleton\Web\Test\Unit\Module\User\Security\UserProfile;

use PHPUnit\Framework\TestCase;
use Skeleton\Web\Module\User\Security\UserProfile\ActionEnum;
use Skeleton\Web\Module\User\Security\UserProfile\PermissionEnum;
use Skeleton\Web\Module\User\Security\UserProfile\Rule;
use Skeleton\Web\Module\User\Security\UserProfile\Voter as UserProfileVoter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchy;

final class VoterTest extends TestCase
{
    public function testVoteWithPermissionGrantsAccess(): void
    {
        $voter = $this->createVoter();
        $token = new TokenStub([PermissionEnum::viewProfiles->value]);

        self::assertSame(
            VoterInterface::ACCESS_GRANTED,
            $voter->vote($token, null, [ActionEnum::listProfiles->value]),
        );
    }

    public function testVoteWithoutPermissionDeniesAccess(): void
    {
        $voter = $this->createVoter();
        $token = new TokenStub([]);

        self::assertSame(
            VoterInterface::ACCESS_DENIED,
            $voter->vote($token, null, [ActionEnum::listProfiles->value]),
        );
    }

    public function testVoteWithUnsupportedSubjectAbstains(): void
    {
        $voter = $this->createVoter();
        $token = new TokenStub([PermissionEnum::viewProfiles->value]);

        self::assertSame(
            VoterInterface::ACCESS_ABSTAIN,
            $voter->vote($token, 'unexpected-subject', [ActionEnum::listProfiles->value]),
        );
    }

    public function testVoteWithUnsupportedActionAbstains(): void
    {
        $voter = $this->createVoter();
        $token = new TokenStub([PermissionEnum::viewProfiles->value]);

        self::assertSame(
            VoterInterface::ACCESS_ABSTAIN,
            $voter->vote($token, null, ['user.user_profile.unsupported']),
        );
    }

    private function createVoter(): UserProfileVoter
    {
        return new UserProfileVoter(new Rule(new RoleHierarchy([])));
    }
}
