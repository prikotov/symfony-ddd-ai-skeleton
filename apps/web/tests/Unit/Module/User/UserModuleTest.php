<?php

declare(strict_types=1);

namespace Skeleton\Web\Test\Unit\Module\User;

use PHPUnit\Framework\TestCase;
use Skeleton\Common\Component\ModuleSystem\Extension\TwigInterface;
use Skeleton\Common\Component\ModuleSystem\ModuleInterface;
use Skeleton\Web\Module\User\UserModule;

final class UserModuleTest extends TestCase
{
    public function testUserModuleProvidesConfigAndTwigTemplatePath(): void
    {
        $module = new UserModule();

        self::assertInstanceOf(ModuleInterface::class, $module);
        self::assertInstanceOf(TwigInterface::class, $module);
        self::assertSame((string) realpath(__DIR__ . '/../../../../src/Module/User'), $module->getModuleDir());
        self::assertSame($module->getModuleDir() . '/Resource/config', $module->getModuleConfigPath());
        self::assertSame($module->getModuleDir() . '/Resource/templates', $module->getBaseTemplatesPath());
        self::assertDirectoryExists($module->getBaseTemplatesPath());
        self::assertSame('WebUser', $module->getBaseTwigNamespace());
        self::assertSame([], $module->getAdditionalTemplatesPaths());
    }
}
