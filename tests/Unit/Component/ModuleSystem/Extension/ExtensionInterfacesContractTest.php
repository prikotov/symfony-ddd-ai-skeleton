<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Component\ModuleSystem\Extension;

use Override;
use PHPUnit\Framework\TestCase;
use Skeleton\Common\Component\ModuleSystem\Extension\DoctrineInterface;
use Skeleton\Common\Component\ModuleSystem\Extension\TranslationInterface;
use Skeleton\Common\Component\ModuleSystem\Extension\TwigInterface;
use Skeleton\Common\Component\ModuleSystem\ModuleInterface;

final class ExtensionInterfacesContractTest extends TestCase
{
    public function testDoctrineInterfaceContract(): void
    {
        $module = new class implements DoctrineInterface {
            #[Override]
            public function getEntityNamespace(): string
            {
                return __NAMESPACE__ . '\Entity';
            }

            #[Override]
            public function getMappingPath(): string
            {
                return __DIR__ . '/Entity';
            }
        };

        self::assertNotEmpty($module->getEntityNamespace());
        self::assertNotEmpty($module->getMappingPath());
        self::assertStringContainsString('Entity', $module->getEntityNamespace());
        self::assertStringContainsString('Entity', $module->getMappingPath());
    }

    public function testTwigInterfaceContract(): void
    {
        $module = new class implements TwigInterface {
            #[Override]
            public function getBaseTemplatesPath(): string
            {
                return '/module/templates';
            }

            #[Override]
            public function getBaseTwigNamespace(): string
            {
                return 'TestModule';
            }

            #[Override]
            public function getAdditionalTemplatesPaths(): array
            {
                return ['/module/extra' => 'TestModuleExtra'];
            }
        };

        self::assertSame('/module/templates', $module->getBaseTemplatesPath());
        self::assertSame('TestModule', $module->getBaseTwigNamespace());
        self::assertSame(['/module/extra' => 'TestModuleExtra'], $module->getAdditionalTemplatesPaths());
    }

    public function testTranslationInterfaceContract(): void
    {
        $module = new class implements TranslationInterface {
            #[Override]
            public function getBaseTranslationsPath(): string
            {
                return '/module/translations';
            }

            #[Override]
            public function getAdditionalTranslationsPaths(): array
            {
                return ['/module/extra-translations'];
            }
        };

        self::assertSame('/module/translations', $module->getBaseTranslationsPath());
        self::assertSame(['/module/extra-translations'], $module->getAdditionalTranslationsPaths());
    }

    public function testModuleCanImplementMultipleExtensions(): void
    {
        $module = new class implements ModuleInterface, DoctrineInterface, TwigInterface, TranslationInterface {
            #[Override]
            public function getModuleDir(): string
            {
                return '/module';
            }

            #[Override]
            public function getModuleConfigPath(): string
            {
                return '/module/Resource/config';
            }

            #[Override]
            public function getEntityNamespace(): string
            {
                return __NAMESPACE__ . '\Entity';
            }

            #[Override]
            public function getMappingPath(): string
            {
                return '/module/Domain/Entity';
            }

            #[Override]
            public function getBaseTemplatesPath(): string
            {
                return '/module/Resource/templates';
            }

            #[Override]
            public function getBaseTwigNamespace(): string
            {
                return 'FullModule';
            }

            #[Override]
            public function getAdditionalTemplatesPaths(): array
            {
                return [];
            }

            #[Override]
            public function getBaseTranslationsPath(): string
            {
                return '/module/Resource/translations';
            }

            #[Override]
            public function getAdditionalTranslationsPaths(): array
            {
                return [];
            }
        };

        self::assertInstanceOf(ModuleInterface::class, $module);
        self::assertInstanceOf(DoctrineInterface::class, $module);
        self::assertInstanceOf(TwigInterface::class, $module);
        self::assertInstanceOf(TranslationInterface::class, $module);

        // Verify canonical paths
        self::assertSame('/module/Resource/config', $module->getModuleConfigPath());
        self::assertSame('/module/Domain/Entity', $module->getMappingPath());
        self::assertSame('/module/Resource/templates', $module->getBaseTemplatesPath());
        self::assertSame('/module/Resource/translations', $module->getBaseTranslationsPath());
    }
}
