<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit;

use PHPUnit\Framework\TestCase;
use Skeleton\Common\Kernel;

final class SmokeTest extends TestCase
{
    public function testKernelClassIsAvailable(): void
    {
        self::assertTrue(class_exists(Kernel::class));
    }
}
