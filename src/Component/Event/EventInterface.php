<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Event;

use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

interface EventInterface
{
    public function getEventUuid(): Uuid;

    public function getOccurredOn(): DateTimeImmutable;
}
