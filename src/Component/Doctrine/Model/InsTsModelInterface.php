<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Doctrine\Model;

use DateTimeImmutable;

interface InsTsModelInterface
{
    public function getInsTs(): DateTimeImmutable;
}
