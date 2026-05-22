<?php

declare(strict_types=1);

namespace Skeleton\Web\Component\Twig\Phoenix;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class ImportantAlert
{
    public ?string $message = null;
}
