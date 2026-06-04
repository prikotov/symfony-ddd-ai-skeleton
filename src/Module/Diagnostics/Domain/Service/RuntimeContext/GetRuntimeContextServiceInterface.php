<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\Diagnostics\Domain\Service\RuntimeContext;

use Skeleton\Common\Module\Diagnostics\Domain\ValueObject\RuntimeContextVo;

/**
 * Provides local runtime context already available in the application kernel.
 */
interface GetRuntimeContextServiceInterface
{
    public function get(): RuntimeContextVo;
}
