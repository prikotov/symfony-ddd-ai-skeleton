<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Doctrine\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ValueError;

trait IdTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    public function getId(): int
    {
        return $this->id ?? throw new ValueError('Entity is not persisted yet.');
    }
}
