<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Domain\Dto;

/**
 * Consumer-owned scalar snapshot of runtime diagnostics data.
 */
final readonly class RuntimeDiagnosticsSnapshotDto
{
    public function __construct(
        public string $status,
        public string $entrypoint,
        public string $appId,
        public string $environment,
        public bool $debug,
        public string $timezone,
        public string $checkedAt,
    ) {
    }
}
