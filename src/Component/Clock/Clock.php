<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\Clock;

use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use Override;
use Psr\Clock\ClockInterface;

final readonly class Clock implements ClockInterface
{
    public function __construct(
        private string $timezone,
    ) {
    }

    #[Override]
    public function now(): DateTimeImmutable
    {
        if ($this->timezone === '') {
            throw new InvalidArgumentException('Timezone must not be empty.');
        }

        return new DateTimeImmutable('now', new DateTimeZone($this->timezone));
    }
}
