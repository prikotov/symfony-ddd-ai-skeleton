<?php

declare(strict_types=1);

namespace Skeleton\Web\Component\Twig\Phoenix;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Flash
{
    public function mapType(string $type): string
    {
        return $type === 'error' ? Alert::DANGER : $type;
    }
}
