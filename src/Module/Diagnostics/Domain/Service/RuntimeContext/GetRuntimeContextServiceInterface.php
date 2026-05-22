<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\Diagnostics\Domain\Service\RuntimeContext;

use Skeleton\Common\Module\Diagnostics\Domain\ValueObject\RuntimeContextVo;

interface GetRuntimeContextServiceInterface
{
    public function get(): RuntimeContextVo;
}
