<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\Diagnostics\Application\Dto;

use DateTimeImmutable;

final readonly class RuntimeDiagnosticsDto
{
    public function __construct(
        public string $status,
        public string $entrypoint,
        public string $appId,
        public string $environment,
        public bool $debug,
        public string $timezone,
        public DateTimeImmutable $checkedAt,
    ) {
    }
}
