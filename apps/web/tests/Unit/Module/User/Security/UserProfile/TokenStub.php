<?php

declare(strict_types=1);

namespace Skeleton\Web\Test\Unit\Module\User\Security\UserProfile;

use Override;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class TokenStub implements TokenInterface
{
    /** @var array<string, mixed> */
    private array $attributes = [];

    private ?UserInterface $user = null;

    /**
     * @param list<string> $roleNames
     */
    public function __construct(
        private array $roleNames,
    ) {
    }

    #[Override]
    public function __toString(): string
    {
        return 'token-stub';
    }

    /**
     * @return list<string>
     */
    #[Override]
    public function getRoleNames(): array
    {
        return $this->roleNames;
    }

    #[Override]
    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    #[Override]
    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }

    #[Override]
    public function getUserIdentifier(): string
    {
        return 'token-stub-user';
    }

    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array<string, mixed> $attributes
     */
    #[Override]
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    #[Override]
    public function hasAttribute(string $name): bool
    {
        return array_key_exists($name, $this->attributes);
    }

    #[Override]
    public function getAttribute(string $name): mixed
    {
        return $this->attributes[$name] ?? null;
    }

    #[Override]
    public function setAttribute(string $name, mixed $value): void
    {
        $this->attributes[$name] = $value;
    }

    /**
     * @return array{roleNames: list<string>, attributes: array<string, mixed>}
     */
    #[Override]
    public function __serialize(): array
    {
        return [
            'roleNames' => $this->roleNames,
            'attributes' => $this->attributes,
        ];
    }

    /**
     * @param array{roleNames?: list<string>, attributes?: array<string, mixed>} $data
     */
    #[Override]
    public function __unserialize(array $data): void
    {
        $this->roleNames = $data['roleNames'] ?? [];
        $this->attributes = $data['attributes'] ?? [];
    }
}
