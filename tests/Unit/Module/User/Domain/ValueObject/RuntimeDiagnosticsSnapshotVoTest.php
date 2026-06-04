<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Module\User\Domain\ValueObject;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Skeleton\Common\Module\User\Domain\ValueObject\RuntimeDiagnosticsSnapshotVo;

final class RuntimeDiagnosticsSnapshotVoTest extends TestCase
{
    public function testCreateFromValuesWithValidValuesProvidesAccessors(): void
    {
        $snapshot = RuntimeDiagnosticsSnapshotVo::createFromValues(
            status: ' ok ',
            entrypoint: ' user-integration-bridge ',
            appId: ' console ',
            environment: ' test ',
            debug: true,
            timezone: ' Asia/Novosibirsk ',
            checkedAt: ' 2026-06-02T12:34:56+00:00 ',
        );

        self::assertSame('ok', $snapshot->status());
        self::assertSame('user-integration-bridge', $snapshot->entrypoint());
        self::assertSame('console', $snapshot->appId());
        self::assertSame('test', $snapshot->environment());
        self::assertTrue($snapshot->isDebug());
        self::assertSame('Asia/Novosibirsk', $snapshot->timezone());
        self::assertSame('2026-06-02T12:34:56+00:00', $snapshot->checkedAt());
    }

    public function testEqualsWithSameValuesReturnsTrue(): void
    {
        $snapshot = self::createSnapshot();
        $sameSnapshot = self::createSnapshot();

        self::assertTrue($snapshot->equals($sameSnapshot));
    }

    public function testCreateFromValuesWithBlankStatusThrowsInvalidArgumentException(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Runtime diagnostics status must not be empty.');

        RuntimeDiagnosticsSnapshotVo::createFromValues(
            status: ' ',
            entrypoint: 'user-integration-bridge',
            appId: 'console',
            environment: 'test',
            debug: true,
            timezone: 'Asia/Novosibirsk',
            checkedAt: '2026-06-02T12:34:56+00:00',
        );
    }

    private static function createSnapshot(): RuntimeDiagnosticsSnapshotVo
    {
        return RuntimeDiagnosticsSnapshotVo::createFromValues(
            status: 'ok',
            entrypoint: 'user-integration-bridge',
            appId: 'console',
            environment: 'test',
            debug: true,
            timezone: 'Asia/Novosibirsk',
            checkedAt: '2026-06-02T12:34:56+00:00',
        );
    }
}
