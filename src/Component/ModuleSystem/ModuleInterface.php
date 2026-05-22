<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\ModuleSystem;

interface ModuleInterface
{
    public function getModuleDir(): string;

    public function getModuleConfigPath(): string;
}
