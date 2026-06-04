<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\UserProfileRepositoryInterface;
use Skeleton\Common\Module\User\Domain\Service\RuntimeDiagnostics\GetRuntimeDiagnosticsSnapshotServiceInterface;
use Skeleton\Common\Module\User\Infrastructure\Repository\UserProfile\UserProfileRepository;
use Skeleton\Common\Module\User\Integration\Service\RuntimeDiagnostics\GetRuntimeDiagnosticsSnapshotService;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services
        ->alias(EntityManagerInterface::class, 'doctrine.orm.entity_manager')
        ->public();

    $services
        ->alias(UserProfileRepositoryInterface::class, UserProfileRepository::class)
        ->public();

    $services
        ->alias(GetRuntimeDiagnosticsSnapshotServiceInterface::class, GetRuntimeDiagnosticsSnapshotService::class)
        ->public();
};
