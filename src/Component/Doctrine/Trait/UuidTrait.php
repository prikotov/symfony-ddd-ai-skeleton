<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Doctrine\Trait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use ValueError;

trait UuidTrait
{
    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $uuid = null;

    public function getUuid(): Uuid
    {
        return $this->uuid ?? throw new ValueError('Entity UUID is not set.');
    }
}
