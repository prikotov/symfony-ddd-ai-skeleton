<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\ModuleSystem\DependencyInjection;

use Override;
use RuntimeException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Compiler pass that registers module Twig template paths.
 *
 * Validates uniqueness of paths and namespaces, then wires them into
 * the Twig filesystem loader and the `twig.paths` extension config.
 */
final readonly class TwigCompilerPass implements CompilerPassInterface
{
    /**
     * @param array<string, string> $additionalPathMap path => namespace
     */
    public function __construct(
        private string $defaultTemplatePath,
        private string $defaultTwigNamespace,
        private array $additionalPathMap = [],
    ) {
    }

    /**
     * @throws RuntimeException on duplicate path or namespace
     */
    #[Override]
    public function process(ContainerBuilder $container): void
    {
        if (array_key_exists($this->defaultTemplatePath, $this->additionalPathMap)) {
            throw new RuntimeException('Duplicate template path.');
        }

        if (in_array($this->defaultTwigNamespace, $this->additionalPathMap, true)) {
            throw new RuntimeException('Duplicate template namespace.');
        }

        $templatePathMap = [
            ...$this->additionalPathMap,
            $this->defaultTemplatePath => $this->defaultTwigNamespace,
        ];

        $container->prependExtensionConfig('twig', ['paths' => $templatePathMap]);

        $twigFilesystemLoaderDefinition = $container->getDefinition('twig.loader.native_filesystem');
        foreach ($templatePathMap as $templatePath => $namespace) {
            $twigFilesystemLoaderDefinition->addMethodCall('addPath', [$templatePath, $namespace]);
        }
    }
}
