<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Domain\ValueObject;

use InvalidArgumentException;

final readonly class ContactEmailVo
{
    public const int MAX_LENGTH = 254;

    private function __construct(
        private string $value,
    ) {
    }

    public static function createFromEmail(string $email): self
    {
        $normalized = strtolower(trim($email));

        if ($normalized === '') {
            throw new InvalidArgumentException('Contact email must not be empty.');
        }

        if (strlen($normalized) > self::MAX_LENGTH) {
            throw new InvalidArgumentException(sprintf(
                'Contact email must not be longer than %d characters.',
                self::MAX_LENGTH,
            ));
        }

        if (filter_var($normalized, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('Contact email must be a valid email address.');
        }

        return new self($normalized);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
