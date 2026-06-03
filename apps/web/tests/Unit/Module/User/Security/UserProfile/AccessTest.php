<?php

declare(strict_types=1);

namespace Skeleton\Web\Test\Unit\Module\User\Security\UserProfile;

use Override;
use PHPUnit\Framework\TestCase;
use Skeleton\Web\Module\User\Security\UserProfile\Access;
use Skeleton\Web\Module\User\Security\UserProfile\ActionEnum;
use Symfony\Component\Security\Core\Authorization\AccessDecision;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class AccessTest extends TestCase
{
    public function testCanListReturnsAuthorizationCheckerDecision(): void
    {
        $authorizationChecker = new AuthorizationCheckerStub(granted: true);
        $access = new Access($authorizationChecker);

        self::assertTrue($access->canList());
        self::assertSame(ActionEnum::listProfiles->value, $authorizationChecker->lastAttribute);
        self::assertNull($authorizationChecker->lastSubject);
    }

    public function testCanListReturnsFalseWhenAuthorizationCheckerDeniesAccess(): void
    {
        $authorizationChecker = new AuthorizationCheckerStub(granted: false);
        $access = new Access($authorizationChecker);

        self::assertFalse($access->canList());
        self::assertSame(ActionEnum::listProfiles->value, $authorizationChecker->lastAttribute);
        self::assertNull($authorizationChecker->lastSubject);
    }
}

final class AuthorizationCheckerStub implements AuthorizationCheckerInterface
{
    public mixed $lastAttribute = null;

    public mixed $lastSubject = null;

    public function __construct(
        private readonly bool $granted,
    ) {
    }

    #[Override]
    public function isGranted(mixed $attribute, mixed $subject = null, ?AccessDecision $accessDecision = null): bool
    {
        unset($accessDecision);

        $this->lastAttribute = $attribute;
        $this->lastSubject = $subject;

        return $this->granted;
    }
}
