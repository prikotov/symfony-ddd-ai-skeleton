<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\Diagnostics\Application\UseCase\Query\GetRuntimeDiagnostics;

use Skeleton\Common\Application\Query\QueryInterface;
use Skeleton\Common\Module\Diagnostics\Application\Dto\RuntimeDiagnosticsDto;

/**
 * Requests dependency-light runtime diagnostics for a Presentation entrypoint.
 *
 * @implements QueryInterface<RuntimeDiagnosticsDto>
 */
final readonly class GetRuntimeDiagnosticsQuery implements QueryInterface
{
    public function __construct(
        public string $entrypoint,
    ) {
    }
}
