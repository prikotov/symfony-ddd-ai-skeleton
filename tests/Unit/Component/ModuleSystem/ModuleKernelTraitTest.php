<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Component\ModuleSystem;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Override;
use PHPUnit\Framework\TestCase;
use Skeleton\Common\Component\ModuleSystem\DependencyInjection\TwigCompilerPass;
use Skeleton\Common\Component\ModuleSystem\Extension\DoctrineInterface;
use Skeleton\Common\Component\ModuleSystem\Extension\TranslationInterface;
use Skeleton\Common\Component\ModuleSystem\Extension\TwigInterface;
use Skeleton\Common\Component\ModuleSystem\ModuleInterface;
use Skeleton\Common\Component\ModuleSystem\ModuleKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ModuleKernelTraitTest extends TestCase
{
    private ContainerBuilder $container;
    private TestKernel $kernel;

    #[Override]
    protected function setUp(): void
    {
        $this->kernel = new TestKernel();
        $this->container = new ContainerBuilder();
    }

    public function testBareModuleGetsNoTwigDoctrineOrTranslationBehavior(): void
    {
        $this->kernel->registerModulesPublic($this->container, [
            StubBareModule::class => ['test' => true],
        ]);

        $passes = $this->getCompilerPasses();

        foreach ($passes as $pass) {
            self::assertNotInstanceOf(TwigCompilerPass::class, $pass, 'Bare module must not trigger TwigCompilerPass.');
            self::assertNotInstanceOf(DoctrineOrmMappingsPass::class, $pass, 'Bare module must not trigger DoctrineOrmMappingsPass.');
        }

        $frameworkConfig = $this->container->getExtensionConfig('framework');
        foreach ($frameworkConfig as $config) {
            self::assertArrayNotHasKey('translator', $config, 'Bare module must not prepend translator config.');
        }
    }

    public function testTwigModuleGetsTwigCompilerPass(): void
    {
        $this->kernel->registerModulesPublic($this->container, [
            StubTwigModule::class => ['test' => true],
        ]);

        $twigPasses = $this->filterPasses(TwigCompilerPass::class);
        self::assertCount(1, $twigPasses, 'TwigInterface module must register exactly one TwigCompilerPass.');
    }

    public function testDoctrineModuleGetsMappingPassWhenDirectoryExists(): void
    {
        $this->kernel->registerModulesPublic($this->container, [
            StubDoctrineModule::class => ['test' => true],
        ]);

        $doctrinePasses = $this->filterPasses(DoctrineOrmMappingsPass::class);
        self::assertCount(1, $doctrinePasses, 'DoctrineInterface module must register DoctrineOrmMappingsPass when mapping dir exists.');
    }

    public function testDoctrineModuleSkipsPassWhenDirectoryMissing(): void
    {
        $this->kernel->registerModulesPublic($this->container, [
            StubDoctrineMissingDirModule::class => ['test' => true],
        ]);

        $doctrinePasses = $this->filterPasses(DoctrineOrmMappingsPass::class);
        self::assertCount(0, $doctrinePasses, 'DoctrineInterface module must not register pass when mapping dir is missing.');
    }

    public function testTranslationModulePrependsFrameworkTranslatorPaths(): void
    {
        $this->kernel->registerModulesPublic($this->container, [
            StubTranslationModule::class => ['test' => true],
        ]);

        $frameworkConfig = $this->container->getExtensionConfig('framework');

        $collectedPaths = [];
        foreach ($frameworkConfig as $config) {
            if (isset($config['translator']['paths'])) {
                $collectedPaths = [...$collectedPaths, ...$config['translator']['paths']];
            }
        }

        self::assertContains('/module/translations', $collectedPaths, 'Base translations path must be registered.');
        self::assertContains('/module/extra-translations', $collectedPaths, 'Additional translations path must be registered.');
    }

    public function testExcludedEnvironmentSkipsModule(): void
    {
        $this->kernel->registerModulesPublic($this->container, [
            StubTwigModule::class => ['test' => false, 'prod' => true],
        ]);

        $twigPasses = $this->filterPasses(TwigCompilerPass::class);
        self::assertCount(0, $twigPasses, 'Module excluded for current environment must not register any extension pass.');
    }

    /**
     * @return list<object>
     */
    private function getCompilerPasses(): array
    {
        $config = $this->container->getCompilerPassConfig();

        return [
            ...$config->getBeforeOptimizationPasses(),
            ...$config->getOptimizationPasses(),
            ...$config->getBeforeRemovingPasses(),
            ...$config->getRemovingPasses(),
            ...$config->getAfterRemovingPasses(),
        ];
    }

    /**
     * @param class-string $className
     * @return list<object>
     */
    private function filterPasses(string $className): array
    {
        return array_values(array_filter(
            $this->getCompilerPasses(),
            static fn(object $pass): bool => $pass instanceof $className,
        ));
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Test kernel: exposes the private trait method for testing
// ─────────────────────────────────────────────────────────────────────────────

class TestKernel
{
    use ModuleKernelTrait;

    public string $environment = 'test';

    /**
     * @param array<string, bool> $envs
     */
    public function isEnvironmentIncluded(array $envs): bool
    {
        return $envs[$this->environment] ?? false;
    }

    /**
     * @param array<class-string, array<string, bool>> $modules
     */
    public function registerModulesPublic(ContainerBuilder $container, array $modules): void
    {
        $this->registerModules($container, $modules);
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Stub modules
// ─────────────────────────────────────────────────────────────────────────────

class StubBareModule implements ModuleInterface
{
    #[Override]
    public function getModuleDir(): string
    {
        return '/tmp/stub-bare';
    }

    #[Override]
    public function getModuleConfigPath(): string
    {
        return '/tmp/stub-bare/Resource/config';
    }
}

class StubTwigModule implements ModuleInterface, TwigInterface
{
    #[Override]
    public function getModuleDir(): string
    {
        return '/tmp/stub-twig';
    }

    #[Override]
    public function getModuleConfigPath(): string
    {
        return '/tmp/stub-twig/Resource/config';
    }

    #[Override]
    public function getBaseTemplatesPath(): string
    {
        return '/tmp/stub-twig/Resource/templates';
    }

    #[Override]
    public function getBaseTwigNamespace(): string
    {
        return 'StubTwig';
    }

    #[Override]
    public function getAdditionalTemplatesPaths(): array
    {
        return [];
    }
}

class StubDoctrineModule implements ModuleInterface, DoctrineInterface
{
    #[Override]
    public function getModuleDir(): string
    {
        return '/tmp/stub-doctrine';
    }

    #[Override]
    public function getModuleConfigPath(): string
    {
        return '/tmp/stub-doctrine/Resource/config';
    }

    #[Override]
    public function getEntityNamespace(): string
    {
        return __NAMESPACE__ . '\Entity';
    }

    #[Override]
    public function getMappingPath(): string
    {
        return __DIR__;
    }
}

class StubDoctrineMissingDirModule implements ModuleInterface, DoctrineInterface
{
    #[Override]
    public function getModuleDir(): string
    {
        return '/tmp/stub-doctrine-missing';
    }

    #[Override]
    public function getModuleConfigPath(): string
    {
        return '/tmp/stub-doctrine-missing/Resource/config';
    }

    #[Override]
    public function getEntityNamespace(): string
    {
        return __NAMESPACE__ . '\Entity';
    }

    #[Override]
    public function getMappingPath(): string
    {
        return '/nonexistent/mapping/path';
    }
}

class StubTranslationModule implements ModuleInterface, TranslationInterface
{
    #[Override]
    public function getModuleDir(): string
    {
        return '/tmp/stub-translation';
    }

    #[Override]
    public function getModuleConfigPath(): string
    {
        return '/tmp/stub-translation/Resource/config';
    }

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
}
