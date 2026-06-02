<?php

declare(strict_types=1);

namespace Skeleton\Console\Test\Integration\Module\Diagnostics\Command\Runtime;

use DateTimeImmutable;
use JsonException;
use Override;
use Skeleton\Common\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;

final class CheckCommandTest extends KernelTestCase
{
    /**
     * @throws JsonException
     */
    public function testExecuteWithConsoleKernelReturnsRuntimeDiagnostics(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:diagnostics:runtime');
        $commandTester = new CommandTester($command);

        $exitCode = $commandTester->execute([]);

        self::assertSame(Command::SUCCESS, $exitCode);

        /** @var array{status: string, entrypoint: string, app: string, environment: string, debug: bool, timezone: string, checkedAt: string} $payload */
        $payload = json_decode($commandTester->getDisplay(), true, 512, JSON_THROW_ON_ERROR);

        self::assertSame('ok', $payload['status']);
        self::assertSame('console-command', $payload['entrypoint']);
        self::assertSame('console', $payload['app']);
        self::assertSame('test', $payload['environment']);
        self::assertTrue($payload['debug']);
        self::assertSame('Asia/Novosibirsk', $payload['timezone']);
        self::assertInstanceOf(
            DateTimeImmutable::class,
            DateTimeImmutable::createFromFormat(DATE_ATOM, $payload['checkedAt']),
        );
    }

    #[Override]
    protected static function createKernel(array $options = []): KernelInterface
    {
        $_SERVER['APP_ENV'] = 'test';
        $_SERVER['APP_DEBUG'] = '1';
        $_SERVER['APP_SECRET'] = 'test';
        $_SERVER['DATABASE_URL'] = 'sqlite:///:memory:';
        $_SERVER['APP_CACHE_DIR'] = sys_get_temp_dir() . '/skeleton-tests/cache';
        $_SERVER['APP_LOG_DIR'] = sys_get_temp_dir() . '/skeleton-tests/log';

        return new Kernel('test', true, 'console');
    }
}
