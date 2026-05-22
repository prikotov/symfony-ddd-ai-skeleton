<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\Diagnostics\Domain\ValueObject;

use InvalidArgumentException;

final readonly class RuntimeContextVo
{
    private function __construct(
        private readonly string $appId,
        private readonly string $environment,
        private readonly bool $debug,
    ) {
    }

    public static function createFromValues(
        string $appId,
        string $environment,
        bool $debug,
    ): self {
        $appId = trim($appId);
        $environment = trim($environment);

        if ($appId === '') {
            throw new InvalidArgumentException('App id must not be empty.');
        }

        if ($environment === '') {
            throw new InvalidArgumentException('Environment must not be empty.');
        }

        return new self(
            appId: $appId,
            environment: $environment,
            debug: $debug,
        );
    }

    public function appId(): string
    {
        return $this->appId;
    }

    public function environment(): string
    {
        return $this->environment;
    }

    public function isDebug(): bool
    {
        return $this->debug;
    }

    public function equals(self $other): bool
    {
        return $this->appId === $other->appId
            && $this->environment === $other->environment
            && $this->debug === $other->debug;
    }
}
