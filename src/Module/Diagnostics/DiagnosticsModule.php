<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\Diagnostics;

use Override;
use Skeleton\Common\Component\ModuleSystem\ModuleInterface;

final readonly class DiagnosticsModule implements ModuleInterface
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
}
