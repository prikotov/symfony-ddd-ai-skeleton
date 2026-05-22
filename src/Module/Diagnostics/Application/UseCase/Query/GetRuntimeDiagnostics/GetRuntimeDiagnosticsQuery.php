<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\Diagnostics\Application\UseCase\Query\GetRuntimeDiagnostics;

use Skeleton\Common\Application\Query\QueryInterface;
use Skeleton\Common\Module\Diagnostics\Application\Dto\RuntimeDiagnosticsDto;

/**
 * @implements QueryInterface<RuntimeDiagnosticsDto>
 */
final readonly class GetRuntimeDiagnosticsQuery implements QueryInterface
{
    public function __construct(
        public string $entrypoint,
    ) {
    }
}
