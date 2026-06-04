<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Module\User;

use PHPUnit\Framework\TestCase;
use Skeleton\Common\Component\ModuleSystem\Extension\DoctrineInterface;
use Skeleton\Common\Component\ModuleSystem\ModuleInterface;
use Skeleton\Common\Module\User\UserModule;

final class UserModuleTest extends TestCase
{
    public function testUserModuleProvidesConfigAndDoctrineMappingPaths(): void
    {
        $module = new UserModule();

        self::assertInstanceOf(ModuleInterface::class, $module);
        self::assertInstanceOf(DoctrineInterface::class, $module);
        self::assertSame((string) realpath(__DIR__ . '/../../../../src/Module/User'), $module->getModuleDir());
        self::assertSame($module->getModuleDir() . '/Resource/config', $module->getModuleConfigPath());
        self::assertSame('Skeleton\Common\Module\User\Domain\Entity', $module->getEntityNamespace());
        self::assertSame($module->getModuleDir() . '/Domain/Entity', $module->getMappingPath());
        self::assertDirectoryExists($module->getMappingPath());
    }
}
