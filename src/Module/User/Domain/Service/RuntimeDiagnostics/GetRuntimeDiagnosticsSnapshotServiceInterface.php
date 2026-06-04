<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Domain\Service\RuntimeDiagnostics;

use Skeleton\Common\Module\User\Domain\ValueObject\RuntimeDiagnosticsSnapshotVo;

/**
 * Consumer-owned contract for reading runtime diagnostics from another module.
 */
interface GetRuntimeDiagnosticsSnapshotServiceInterface
{
    public function get(): RuntimeDiagnosticsSnapshotVo;
}
