<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Module\User\Domain\ValueObject;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Skeleton\Common\Module\User\Domain\ValueObject\DisplayNameVo;

final class DisplayNameVoTest extends TestCase
{
    public function testCreateFromStringNormalizesWhitespace(): void
    {
        $displayName = DisplayNameVo::createFromString('  Ada   Lovelace  ');

        self::assertSame('Ada Lovelace', $displayName->toString());
    }

    public function testEqualsWithSameValueReturnsTrue(): void
    {
        $displayName = DisplayNameVo::createFromString('Ada Lovelace');
        $sameDisplayName = DisplayNameVo::createFromString('Ada Lovelace');

        self::assertTrue($displayName->equals($sameDisplayName));
    }

    public function testCreateFromStringWithBlankValueThrowsInvalidArgumentException(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Display name must not be empty.');

        DisplayNameVo::createFromString('   ');
    }

    public function testCreateFromStringWithTooLongValueThrowsInvalidArgumentException(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Display name must not be longer than 120 characters.');

        DisplayNameVo::createFromString(str_repeat('a', DisplayNameVo::MAX_LENGTH + 1));
    }
}
