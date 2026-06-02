<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Component\ModuleSystem\DependencyInjection;

use Override;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Skeleton\Common\Component\ModuleSystem\DependencyInjection\TwigCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class TwigCompilerPassTest extends TestCase
{
    private ContainerBuilder $container;

    #[Override]
    protected function setUp(): void
    {
        $this->container = new ContainerBuilder();

        // Register the twig.loader.native_filesystem definition required by the compiler pass
        $loaderDefinition = new Definition(\Twig\Loader\FilesystemLoader::class);
        $this->container->setDefinition('twig.loader.native_filesystem', $loaderDefinition);
    }

    public function testRegistersDefaultPath(): void
    {
        $pass = new TwigCompilerPass(
            defaultTemplatePath: '/module/templates',
            defaultTwigNamespace: 'TestModule',
        );

        $pass->process($this->container);

        $twigConfig = $this->container->getExtensionConfig('twig');
        self::assertNotEmpty($twigConfig);

        $paths = $twigConfig[0]['paths'] ?? [];
        self::assertArrayHasKey('/module/templates', $paths);
        self::assertSame('TestModule', $paths['/module/templates']);
    }

    public function testRegistersAdditionalPaths(): void
    {
        $pass = new TwigCompilerPass(
            defaultTemplatePath: '/module/templates',
            defaultTwigNamespace: 'TestModule',
            additionalPathMap: ['/module/extra' => 'TestModuleExtra'],
        );

        $pass->process($this->container);

        $twigConfig = $this->container->getExtensionConfig('twig');
        $paths = $twigConfig[0]['paths'] ?? [];

        self::assertArrayHasKey('/module/templates', $paths);
        self::assertArrayHasKey('/module/extra', $paths);
        self::assertSame('TestModule', $paths['/module/templates']);
        self::assertSame('TestModuleExtra', $paths['/module/extra']);
    }

    public function testAddsMethodCallsToFilesystemLoader(): void
    {
        $pass = new TwigCompilerPass(
            defaultTemplatePath: '/module/templates',
            defaultTwigNamespace: 'TestModule',
            additionalPathMap: ['/module/extra' => 'TestModuleExtra'],
        );

        $pass->process($this->container);

        $definition = $this->container->getDefinition('twig.loader.native_filesystem');
        $methodCalls = $definition->getMethodCalls();

        self::assertCount(2, $methodCalls);
        self::assertSame('addPath', $methodCalls[0][0]);
        self::assertSame(['/module/extra', 'TestModuleExtra'], $methodCalls[0][1]);
        self::assertSame('addPath', $methodCalls[1][0]);
        self::assertSame(['/module/templates', 'TestModule'], $methodCalls[1][1]);
    }

    public function testThrowsOnDuplicatePath(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Duplicate template path.');

        $pass = new TwigCompilerPass(
            defaultTemplatePath: '/module/templates',
            defaultTwigNamespace: 'TestModule',
            additionalPathMap: ['/module/templates' => 'OtherNamespace'],
        );

        $pass->process($this->container);
    }

    public function testThrowsOnDuplicateNamespace(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Duplicate template namespace.');

        $pass = new TwigCompilerPass(
            defaultTemplatePath: '/module/templates',
            defaultTwigNamespace: 'TestModule',
            additionalPathMap: ['/module/other' => 'TestModule'],
        );

        $pass->process($this->container);
    }
}
