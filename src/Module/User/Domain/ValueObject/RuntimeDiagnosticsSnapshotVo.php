<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Domain\ValueObject;

use InvalidArgumentException;

/**
 * Consumer-owned value object for runtime diagnostics data read from another module.
 */
final readonly class RuntimeDiagnosticsSnapshotVo
{
    private function __construct(
        private string $status,
        private string $entrypoint,
        private string $appId,
        private string $environment,
        private bool $debug,
        private string $timezone,
        private string $checkedAt,
    ) {
    }

    public static function createFromValues(
        string $status,
        string $entrypoint,
        string $appId,
        string $environment,
        bool $debug,
        string $timezone,
        string $checkedAt,
    ): self {
        $status = trim($status);
        $entrypoint = trim($entrypoint);
        $appId = trim($appId);
        $environment = trim($environment);
        $timezone = trim($timezone);
        $checkedAt = trim($checkedAt);

        if ($status === '') {
            throw new InvalidArgumentException('Runtime diagnostics status must not be empty.');
        }

        if ($entrypoint === '') {
            throw new InvalidArgumentException('Runtime diagnostics entrypoint must not be empty.');
        }

        if ($appId === '') {
            throw new InvalidArgumentException('Runtime diagnostics app id must not be empty.');
        }

        if ($environment === '') {
            throw new InvalidArgumentException('Runtime diagnostics environment must not be empty.');
        }

        if ($timezone === '') {
            throw new InvalidArgumentException('Runtime diagnostics timezone must not be empty.');
        }

        if ($checkedAt === '') {
            throw new InvalidArgumentException('Runtime diagnostics checked at must not be empty.');
        }

        return new self(
            status: $status,
            entrypoint: $entrypoint,
            appId: $appId,
            environment: $environment,
            debug: $debug,
            timezone: $timezone,
            checkedAt: $checkedAt,
        );
    }

    public function status(): string
    {
        return $this->status;
    }

    public function entrypoint(): string
    {
        return $this->entrypoint;
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

    public function timezone(): string
    {
        return $this->timezone;
    }

    public function checkedAt(): string
    {
        return $this->checkedAt;
    }

    public function equals(self $other): bool
    {
        return $this->status === $other->status
            && $this->entrypoint === $other->entrypoint
            && $this->appId === $other->appId
            && $this->environment === $other->environment
            && $this->debug === $other->debug
            && $this->timezone === $other->timezone
            && $this->checkedAt === $other->checkedAt;
    }
}
