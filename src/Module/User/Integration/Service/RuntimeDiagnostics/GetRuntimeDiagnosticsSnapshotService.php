<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Integration\Service\RuntimeDiagnostics;

use Override;
use Skeleton\Common\Application\Component\QueryBus\QueryBusComponentInterface;
use Skeleton\Common\Module\Diagnostics\Application\UseCase\Query\GetRuntimeDiagnostics\GetRuntimeDiagnosticsQuery;
use Skeleton\Common\Module\User\Domain\Service\RuntimeDiagnostics\GetRuntimeDiagnosticsSnapshotServiceInterface;
use Skeleton\Common\Module\User\Domain\ValueObject\RuntimeDiagnosticsSnapshotVo;

/**
 * Calls the Diagnostics Application query and maps its DTO to the User-owned snapshot.
 */
final readonly class GetRuntimeDiagnosticsSnapshotService implements GetRuntimeDiagnosticsSnapshotServiceInterface
{
    private const string ENTRYPOINT = 'user-integration-bridge';

    public function __construct(
        private QueryBusComponentInterface $queryBus,
    ) {
    }

    #[Override]
    public function get(): RuntimeDiagnosticsSnapshotVo
    {
        $diagnostics = $this->queryBus->query(new GetRuntimeDiagnosticsQuery(self::ENTRYPOINT));

        return RuntimeDiagnosticsSnapshotVo::createFromValues(
            status: $diagnostics->status,
            entrypoint: $diagnostics->entrypoint,
            appId: $diagnostics->appId,
            environment: $diagnostics->environment,
            debug: $diagnostics->debug,
            timezone: $diagnostics->timezone,
            checkedAt: $diagnostics->checkedAt->format(DATE_ATOM),
        );
    }
}
