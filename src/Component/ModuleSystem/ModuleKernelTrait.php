<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\ModuleSystem;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use RuntimeException;
use Skeleton\Common\Component\ModuleSystem\DependencyInjection\ModuleCompilerPass;
use Skeleton\Common\Component\ModuleSystem\DependencyInjection\TwigCompilerPass;
use Skeleton\Common\Component\ModuleSystem\Extension\DoctrineInterface;
use Skeleton\Common\Component\ModuleSystem\Extension\TranslationInterface;
use Skeleton\Common\Component\ModuleSystem\Extension\TwigInterface;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Trait for kernel classes that register modules with extension points.
 *
 * Handles: service config (ModuleCompilerPass), Doctrine mappings,
 * Twig templates, and translations — all per-module explicitly.
 *
 * @method bool isEnvironmentIncluded(array<string, bool> $envs)
 * @method string getProjectDir()
 */
trait ModuleKernelTrait
{
    /**
     * @param array<class-string, array<string, bool>> $modules
     */
    private function registerModules(ContainerBuilder $container, array $modules): void
    {
        foreach ($modules as $class => $envs) {
            if (!$this->isEnvironmentIncluded($envs)) {
                continue;
            }

            if (!class_exists($class)) {
                throw new RuntimeException(sprintf('Class %s does not exist.', $class));
            }

            $module = new $class();
            if (!$module instanceof ModuleInterface) {
                throw new RuntimeException(
                    sprintf('Module must implement %s interface.', ModuleInterface::class),
                );
            }

            // Service configuration
            $container->addCompilerPass(
                new ModuleCompilerPass($module->getModuleConfigPath(), $this->environment),
                PassConfig::TYPE_BEFORE_OPTIMIZATION,
                10000,
            );

            // Twig templates
            if ($module instanceof TwigInterface) {
                $container->addCompilerPass(
                    new TwigCompilerPass(
                        defaultTemplatePath: $module->getBaseTemplatesPath(),
                        defaultTwigNamespace: $module->getBaseTwigNamespace(),
                        additionalPathMap: $module->getAdditionalTemplatesPaths(),
                    ),
                );
            }

            // Translations
            if ($module instanceof TranslationInterface) {
                $container->prependExtensionConfig('framework', [
                    'translator' => ['paths' => [$module->getBaseTranslationsPath()]],
                ]);

                foreach ($module->getAdditionalTranslationsPaths() as $path) {
                    $container->prependExtensionConfig('framework', [
                        'translator' => ['paths' => [$path]],
                    ]);
                }
            }

            // Doctrine ORM mappings (explicit, no auto_mapping)
            if (
                $module instanceof DoctrineInterface
                && is_dir($module->getMappingPath())
            ) {
                $container->addCompilerPass(DoctrineOrmMappingsPass::createAttributeMappingDriver(
                    [$module->getEntityNamespace()],
                    [$module->getMappingPath()],
                ));
            }
        }
    }
}
