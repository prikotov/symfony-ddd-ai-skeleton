<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Component\Clock;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Psr\Clock\ClockInterface;
use Skeleton\Common\Component\Clock\Clock;

final class ClockTest extends TestCase
{
    public function testClockImplementsPsrClockInterface(): void
    {
        $clock = new Clock('Asia/Novosibirsk');

        self::assertInstanceOf(ClockInterface::class, $clock);
    }

    public function testNowReturnsDateTimeInConfiguredTimezone(): void
    {
        $clock = new Clock('Asia/Novosibirsk');

        $now = $clock->now();

        self::assertSame('Asia/Novosibirsk', $now->getTimezone()->getName());
    }

    public function testNowWithEmptyTimezoneThrowsInvalidArgumentException(): void
    {
        $clock = new Clock('');

        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Timezone must not be empty.');

        $clock->now();
    }
}
