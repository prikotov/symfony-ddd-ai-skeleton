<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Domain\ValueObject;

use InvalidArgumentException;

final readonly class DisplayNameVo
{
    public const int MAX_LENGTH = 120;

    private function __construct(
        private string $value,
    ) {
    }

    public static function createFromString(string $value): self
    {
        $normalized = trim(preg_replace('/\s+/u', ' ', $value) ?? '');

        if ($normalized === '') {
            throw new InvalidArgumentException('Display name must not be empty.');
        }

        if (strlen($normalized) > self::MAX_LENGTH) {
            throw new InvalidArgumentException(sprintf(
                'Display name must not be longer than %d characters.',
                self::MAX_LENGTH,
            ));
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
