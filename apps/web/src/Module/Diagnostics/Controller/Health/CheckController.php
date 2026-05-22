<?php

declare(strict_types=1);

namespace Skeleton\Web\Module\Diagnostics\Controller\Health;

use LogicException;
use Skeleton\Common\Application\Component\QueryBus\QueryBusComponentInterface;
use Skeleton\Common\Module\Diagnostics\Application\Dto\RuntimeDiagnosticsDto;
use Skeleton\Common\Module\Diagnostics\Application\UseCase\Query\GetRuntimeDiagnostics\GetRuntimeDiagnosticsQuery;
use Skeleton\Web\Module\Diagnostics\Route\HealthRoute;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: HealthRoute::CHECK_PATH, name: HealthRoute::CHECK, methods: [Request::METHOD_GET])]
#[AsController]
final readonly class CheckController
{
    public function __construct(
        private QueryBusComponentInterface $queryBus,
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $diagnostics = $this->queryBus->query(new GetRuntimeDiagnosticsQuery('web-health'));
        if (!$diagnostics instanceof RuntimeDiagnosticsDto) {
            throw new LogicException(sprintf('Expected %s diagnostics result.', RuntimeDiagnosticsDto::class));
        }

        return new JsonResponse($this->normalize($diagnostics));
    }

    /**
     * @return array{status: string, entrypoint: string, app: string, environment: string, debug: bool, timezone: string, checkedAt: string}
     */
    private function normalize(RuntimeDiagnosticsDto $diagnostics): array
    {
        return [
            'status' => $diagnostics->status,
            'entrypoint' => $diagnostics->entrypoint,
            'app' => $diagnostics->appId,
            'environment' => $diagnostics->environment,
            'debug' => $diagnostics->debug,
            'timezone' => $diagnostics->timezone,
            'checkedAt' => $diagnostics->checkedAt->format(DATE_ATOM),
        ];
    }
}
