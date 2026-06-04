<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Integration\Module\User;

use Override;
use Skeleton\Common\Kernel;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\UserProfileRepositoryInterface;
use Skeleton\Common\Module\User\Domain\Service\RuntimeDiagnostics\GetRuntimeDiagnosticsSnapshotServiceInterface;
use Skeleton\Common\Module\User\Infrastructure\Repository\UserProfile\UserProfileRepository;
use Skeleton\Common\Module\User\Integration\Service\RuntimeDiagnostics\Diagnostics\GetRuntimeDiagnosticsSnapshotService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

final class UserModuleWiringTest extends KernelTestCase
{
    public function testKernelRegistersUserProfileRepositoryAliasInTestEnvironment(): void
    {
        $kernel = self::bootKernel();

        $repository = $kernel->getContainer()->get(UserProfileRepositoryInterface::class);

        self::assertInstanceOf(UserProfileRepository::class, $repository);
    }

    public function testKernelRegistersRuntimeDiagnosticsBridgeAliasInTestEnvironment(): void
    {
        $kernel = self::bootKernel();

        $service = $kernel->getContainer()->get(GetRuntimeDiagnosticsSnapshotServiceInterface::class);

        self::assertInstanceOf(GetRuntimeDiagnosticsSnapshotService::class, $service);
    }

    #[Override]
    protected static function createKernel(array $options = []): KernelInterface
    {
        $_SERVER['APP_ENV'] = 'test';
        $_SERVER['APP_DEBUG'] = '1';
        $_SERVER['APP_SECRET'] = 'test';
        $_SERVER['DATABASE_URL'] = 'sqlite:///:memory:';
        $_SERVER['APP_CACHE_DIR'] = sys_get_temp_dir() . '/skeleton-tests/cache-user-module';
        $_SERVER['APP_LOG_DIR'] = sys_get_temp_dir() . '/skeleton-tests/log-user-module';

        return new Kernel('test', true, 'console');
    }
}
