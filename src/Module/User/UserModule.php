<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User;

use Override;
use Skeleton\Common\Component\ModuleSystem\Extension\DoctrineInterface;
use Skeleton\Common\Component\ModuleSystem\ModuleInterface;

final readonly class UserModule implements ModuleInterface, DoctrineInterface
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
    public function getEntityNamespace(): string
    {
        return __NAMESPACE__ . '\Domain\Entity';
    }

    #[Override]
    public function getMappingPath(): string
    {
        return $this->getModuleDir() . '/Domain/Entity';
    }
}
