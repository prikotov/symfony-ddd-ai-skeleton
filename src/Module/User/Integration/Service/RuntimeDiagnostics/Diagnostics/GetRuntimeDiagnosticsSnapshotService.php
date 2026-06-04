<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Integration\Service\RuntimeDiagnostics\Diagnostics;

use LogicException;
use Override;
use Skeleton\Common\Application\Component\QueryBus\QueryBusComponentInterface;
use Skeleton\Common\Module\Diagnostics\Application\Dto\RuntimeDiagnosticsDto;
use Skeleton\Common\Module\Diagnostics\Application\UseCase\Query\GetRuntimeDiagnostics\GetRuntimeDiagnosticsQuery;
use Skeleton\Common\Module\User\Domain\Dto\RuntimeDiagnosticsSnapshotDto;
use Skeleton\Common\Module\User\Domain\Service\RuntimeDiagnostics\GetRuntimeDiagnosticsSnapshotServiceInterface;

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
    public function get(): RuntimeDiagnosticsSnapshotDto
    {
        $diagnostics = $this->queryBus->query(new GetRuntimeDiagnosticsQuery(self::ENTRYPOINT));

        if (!$diagnostics instanceof RuntimeDiagnosticsDto) {
            throw new LogicException(sprintf('Expected %s diagnostics query result.', RuntimeDiagnosticsDto::class));
        }

        return new RuntimeDiagnosticsSnapshotDto(
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
