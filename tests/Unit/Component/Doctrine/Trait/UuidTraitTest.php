<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Component\Doctrine\Trait;

use PHPUnit\Framework\TestCase;
use Skeleton\Common\Component\Doctrine\Model\UuidModelInterface;
use Skeleton\Common\Component\Doctrine\Trait\UuidTrait;
use Symfony\Component\Uid\Uuid;
use ValueError;

final class UuidTraitTest extends TestCase
{
    public function testGetUuidReturnsAssignedUuid(): void
    {
        $uuid = Uuid::fromString('01890f7a-0000-7000-8000-000000000001');
        $model = new class($uuid) implements UuidModelInterface {
            use UuidTrait;

            public function __construct(Uuid $uuid)
            {
                $this->uuid = $uuid;
            }
        };

        self::assertSame($uuid, $model->getUuid());
    }

    public function testGetUuidWhenUnsetThrowsValueError(): void
    {
        $model = new class implements UuidModelInterface {
            use UuidTrait;
        };

        self::expectException(ValueError::class);
        self::expectExceptionMessage('Entity UUID is not set.');

        $model->getUuid();
    }
}
