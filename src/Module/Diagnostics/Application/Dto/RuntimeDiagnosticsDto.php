<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\Diagnostics\Application\Dto;

use DateTimeImmutable;

/**
 * Read-only Application DTO returned by the canonical Diagnostics Query flow.
 *
 * Contains local runtime metadata only; `/health` and CLI diagnostics must not
 * add database, external service, secret or auth-dependent checks to this contract.
 */
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
