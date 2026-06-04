<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\Diagnostics\Application\UseCase\Query\GetRuntimeDiagnostics;

use Psr\Clock\ClockInterface;
use Skeleton\Common\Exception\ConfigurationException;
use Skeleton\Common\Exception\ConfigurationExceptionInterface;
use Skeleton\Common\Module\Diagnostics\Application\Dto\RuntimeDiagnosticsDto;
use Skeleton\Common\Module\Diagnostics\Domain\Service\RuntimeContext\GetRuntimeContextServiceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Builds a read-only diagnostics snapshot without DB or external service probes.
 */
#[AsMessageHandler]
final readonly class GetRuntimeDiagnosticsQueryHandler
{
    public function __construct(
        private GetRuntimeContextServiceInterface $getRuntimeContextService,
        private ClockInterface $clock,
        private string $timezone,
    ) {
    }

    /**
     * @throws ConfigurationExceptionInterface
     */
    public function __invoke(GetRuntimeDiagnosticsQuery $query): RuntimeDiagnosticsDto
    {
        $runtimeContext = $this->getRuntimeContextService->get();

        if ($this->timezone === '') {
            throw new ConfigurationException('Timezone must not be empty.');
        }

        return new RuntimeDiagnosticsDto(
            status: 'ok',
            entrypoint: $query->entrypoint,
            appId: $runtimeContext->appId(),
            environment: $runtimeContext->environment(),
            debug: $runtimeContext->isDebug(),
            timezone: $this->timezone,
            checkedAt: $this->clock->now(),
        );
    }
}
