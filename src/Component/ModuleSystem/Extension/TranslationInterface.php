<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\ModuleSystem\Extension;

/**
 * Extension interface for modules that provide translation resources.
 *
 * Used by web-app modules to register translation file paths.
 * The kernel prepends them to the `framework.translator.paths` config.
 */
interface TranslationInterface
{
    /**
     * Absolute path to the module's primary translations directory.
     *
     * Example: `$this->getModuleDir() . '/Resource/translations'`
     */
    public function getBaseTranslationsPath(): string;

    /**
     * Additional translation directories.
     *
     * @return array<int, string>
     */
    public function getAdditionalTranslationsPaths(): array;
}
