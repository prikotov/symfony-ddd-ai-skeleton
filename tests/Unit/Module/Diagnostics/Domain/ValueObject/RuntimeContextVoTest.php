<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Module\Diagnostics\Domain\ValueObject;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Skeleton\Common\Module\Diagnostics\Domain\ValueObject\RuntimeContextVo;

final class RuntimeContextVoTest extends TestCase
{
    public function testCreateFromValuesWithValidValuesProvidesAccessors(): void
    {
        $runtimeContext = RuntimeContextVo::createFromValues(
            appId: ' console ',
            environment: ' test ',
            debug: true,
        );

        self::assertSame('console', $runtimeContext->appId());
        self::assertSame('test', $runtimeContext->environment());
        self::assertTrue($runtimeContext->isDebug());
    }

    public function testEqualsWithSameValuesReturnsTrue(): void
    {
        $runtimeContext = RuntimeContextVo::createFromValues(
            appId: 'console',
            environment: 'test',
            debug: true,
        );
        $sameRuntimeContext = RuntimeContextVo::createFromValues(
            appId: 'console',
            environment: 'test',
            debug: true,
        );

        self::assertTrue($runtimeContext->equals($sameRuntimeContext));
    }

    public function testEqualsWithDifferentValuesReturnsFalse(): void
    {
        $runtimeContext = RuntimeContextVo::createFromValues(
            appId: 'console',
            environment: 'test',
            debug: true,
        );
        $differentRuntimeContext = RuntimeContextVo::createFromValues(
            appId: 'web',
            environment: 'test',
            debug: true,
        );

        self::assertFalse($runtimeContext->equals($differentRuntimeContext));
    }

    public function testCreateFromValuesWithEmptyAppIdThrowsInvalidArgumentException(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('App id must not be empty.');

        RuntimeContextVo::createFromValues(
            appId: ' ',
            environment: 'test',
            debug: true,
        );
    }

    public function testCreateFromValuesWithEmptyEnvironmentThrowsInvalidArgumentException(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Environment must not be empty.');

        RuntimeContextVo::createFromValues(
            appId: 'console',
            environment: ' ',
            debug: true,
        );
    }
}
