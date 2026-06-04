<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Doctrine\Model;

use Symfony\Component\Uid\Uuid;

interface UuidModelInterface
{
    public function getUuid(): Uuid;
}
