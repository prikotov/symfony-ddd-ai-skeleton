<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Doctrine\Trait;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ValueError;

trait InsTsTrait
{
    #[ORM\Column(name: 'ins_ts', type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $insTs = null;

    public function getInsTs(): DateTimeImmutable
    {
        return $this->insTs ?? throw new ValueError('Entity insert timestamp is not set.');
    }
}
