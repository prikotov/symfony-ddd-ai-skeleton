<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Module\User\Domain\ValueObject;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Skeleton\Common\Module\User\Domain\ValueObject\ContactEmailVo;

final class ContactEmailVoTest extends TestCase
{
    public function testCreateFromEmailNormalizesEmail(): void
    {
        $contactEmail = ContactEmailVo::createFromEmail('  ADA@example.COM  ');

        self::assertSame('ada@example.com', $contactEmail->toString());
    }

    public function testEqualsWithSameValueReturnsTrue(): void
    {
        $contactEmail = ContactEmailVo::createFromEmail('ada@example.com');
        $sameContactEmail = ContactEmailVo::createFromEmail('ADA@example.com');

        self::assertTrue($contactEmail->equals($sameContactEmail));
    }

    public function testCreateFromEmailWithBlankValueThrowsInvalidArgumentException(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Contact email must not be empty.');

        ContactEmailVo::createFromEmail('   ');
    }

    public function testCreateFromEmailWithInvalidValueThrowsInvalidArgumentException(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Contact email must be a valid email address.');

        ContactEmailVo::createFromEmail('not-an-email');
    }
}
