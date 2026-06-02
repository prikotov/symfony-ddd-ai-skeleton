<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\ModuleSystem\Extension;

/**
 * Extension interface for modules that provide Twig templates.
 *
 * Used by web-app modules to register template paths under a namespace.
 * The kernel wires them via {@see \Twig\Loader\FilesystemLoader}.
 */
interface TwigInterface
{
    /**
     * Absolute path to the module's primary templates directory.
     *
     * Example: `$this->getModuleDir() . '/Resource/templates'`
     */
    public function getBaseTemplatesPath(): string;

    /**
     * Twig namespace for the primary templates path.
     *
     * Example: `'WebDiagnostics'`
     */
    public function getBaseTwigNamespace(): string;

    /**
     * Additional template paths mapped to namespaces.
     *
     * @return array<string, string> path => namespace
     */
    public function getAdditionalTemplatesPaths(): array;
}
