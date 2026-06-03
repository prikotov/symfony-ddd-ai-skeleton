<?php

declare(strict_types=1);

namespace Skeleton\Web\Module\User;

use Override;
use Skeleton\Common\Component\ModuleSystem\Extension\TranslationInterface;
use Skeleton\Common\Component\ModuleSystem\Extension\TwigInterface;
use Skeleton\Common\Component\ModuleSystem\ModuleInterface;

final readonly class UserModule implements ModuleInterface, TranslationInterface, TwigInterface
{
    #[Override]
    public function getModuleDir(): string
    {
        return __DIR__;
    }

    #[Override]
    public function getModuleConfigPath(): string
    {
        return $this->getModuleDir() . '/Resource/config';
    }

    #[Override]
    public function getBaseTemplatesPath(): string
    {
        return $this->getModuleDir() . '/Resource/templates';
    }

    #[Override]
    public function getBaseTwigNamespace(): string
    {
        return 'WebUser';
    }

    /**
     * @return array<string, string>
     */
    #[Override]
    public function getAdditionalTemplatesPaths(): array
    {
        return [];
    }

    #[Override]
    public function getBaseTranslationsPath(): string
    {
        return $this->getModuleDir() . '/Resource/translations';
    }

    /**
     * @return array<int, string>
     */
    #[Override]
    public function getAdditionalTranslationsPaths(): array
    {
        return [];
    }
}
