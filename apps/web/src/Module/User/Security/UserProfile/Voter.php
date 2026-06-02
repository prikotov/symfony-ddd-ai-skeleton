<?php

declare(strict_types=1);

namespace Skeleton\Web\Module\User\Security\UserProfile;

use Override;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter as SymfonyVoter;

/**
 * @extends SymfonyVoter<string, null>
 */
final class Voter extends SymfonyVoter
{
    public function __construct(
        private readonly Rule $rule,
    ) {
    }

    #[Override]
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $subject === null && ActionEnum::tryFrom($attribute) !== null;
    }

    #[Override]
    protected function voteOnAttribute(
        string $attribute,
        mixed $subject,
        TokenInterface $token,
        ?Vote $vote = null,
    ): bool {
        unset($subject, $vote);

        $action = ActionEnum::tryFrom($attribute);
        if ($action === null) {
            return false;
        }

        return match ($action) {
            ActionEnum::listProfiles => $this->rule->canList($token),
        };
    }
}
