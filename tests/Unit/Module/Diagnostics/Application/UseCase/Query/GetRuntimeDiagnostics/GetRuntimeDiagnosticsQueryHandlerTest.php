<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Module\Diagnostics\Application\UseCase\Query\GetRuntimeDiagnostics;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Psr\Clock\ClockInterface;
use Skeleton\Common\Exception\ConfigurationExceptionInterface;
use Skeleton\Common\Module\Diagnostics\Application\UseCase\Query\GetRuntimeDiagnostics\GetRuntimeDiagnosticsQuery;
use Skeleton\Common\Module\Diagnostics\Application\UseCase\Query\GetRuntimeDiagnostics\GetRuntimeDiagnosticsQueryHandler;
use Skeleton\Common\Module\Diagnostics\Domain\Service\RuntimeContext\GetRuntimeContextServiceInterface;
use Skeleton\Common\Module\Diagnostics\Domain\ValueObject\RuntimeContextVo;

final class GetRuntimeDiagnosticsQueryHandlerTest extends TestCase
{
    public function testInvokeWithRuntimeContextReturnsDiagnosticsDto(): void
    {
        $checkedAt = new DateTimeImmutable('2026-05-22T00:00:00+00:00');
        $handler = new GetRuntimeDiagnosticsQueryHandler(
            getRuntimeContextService: new GetRuntimeContextServiceStub(RuntimeContextVo::createFromValues(
                appId: 'console',
                environment: 'test',
                debug: true,
            )),
            clock: new ClockStub($checkedAt),
            timezone: 'Asia/Novosibirsk',
        );

        $diagnostics = $handler(new GetRuntimeDiagnosticsQuery('unit-test'));

        self::assertSame('ok', $diagnostics->status);
        self::assertSame('unit-test', $diagnostics->entrypoint);
        self::assertSame('console', $diagnostics->appId);
        self::assertSame('test', $diagnostics->environment);
        self::assertTrue($diagnostics->debug);
        self::assertSame('Asia/Novosibirsk', $diagnostics->timezone);
        self::assertSame($checkedAt, $diagnostics->checkedAt);
    }

    public function testInvokeWithEmptyTimezoneThrowsConfigurationException(): void
    {
        $handler = new GetRuntimeDiagnosticsQueryHandler(
            getRuntimeContextService: new GetRuntimeContextServiceStub(RuntimeContextVo::createFromValues(
                appId: 'console',
                environment: 'test',
                debug: true,
            )),
            clock: new ClockStub(new DateTimeImmutable('2026-05-22T00:00:00+00:00')),
            timezone: '',
        );

        self::expectException(ConfigurationExceptionInterface::class);
        self::expectExceptionMessage('Timezone must not be empty.');

        $handler(new GetRuntimeDiagnosticsQuery('unit-test'));
    }
}

final readonly class GetRuntimeContextServiceStub implements GetRuntimeContextServiceInterface
{
    public function __construct(
        private RuntimeContextVo $runtimeContext,
    ) {
    }

    public function get(): RuntimeContextVo
    {
        return $this->runtimeContext;
    }
}

final readonly class ClockStub implements ClockInterface
{
    public function __construct(
        private DateTimeImmutable $now,
    ) {
    }

    public function now(): DateTimeImmutable
    {
        return $this->now;
    }
}
