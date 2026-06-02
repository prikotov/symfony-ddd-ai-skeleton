<?php

declare(strict_types=1);

use Skeleton\Common\Module\User\Domain\Repository\UserProfile\UserProfileRepositoryInterface;
use Skeleton\Common\Module\User\Domain\Service\Integration\RuntimeDiagnostics\GetRuntimeDiagnosticsSnapshotServiceInterface;
use Skeleton\Common\Module\User\Infrastructure\Repository\UserProfile\InMemoryUserProfileRepository;
use Skeleton\Common\Module\User\Integration\Service\Diagnostics\QueryBusGetRuntimeDiagnosticsSnapshotService;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services
        ->alias(UserProfileRepositoryInterface::class, InMemoryUserProfileRepository::class)
        ->public();

    $services
        ->alias(GetRuntimeDiagnosticsSnapshotServiceInterface::class, QueryBusGetRuntimeDiagnosticsSnapshotService::class)
        ->public();
};
