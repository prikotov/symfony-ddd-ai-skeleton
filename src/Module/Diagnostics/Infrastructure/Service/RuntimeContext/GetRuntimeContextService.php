<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\Diagnostics\Infrastructure\Service\RuntimeContext;

use Override;
use Skeleton\Common\Kernel;
use Skeleton\Common\Module\Diagnostics\Domain\Service\RuntimeContext\GetRuntimeContextServiceInterface;
use Skeleton\Common\Module\Diagnostics\Domain\ValueObject\RuntimeContextVo;

final readonly class GetRuntimeContextService implements GetRuntimeContextServiceInterface
{
    public function __construct(
        private Kernel $kernel,
    ) {
    }

    #[Override]
    public function get(): RuntimeContextVo
    {
        return RuntimeContextVo::createFromValues(
            appId: $this->kernel->getAppId(),
            environment: $this->kernel->getEnvironment(),
            debug: $this->kernel->isDebug(),
        );
    }
}
