<?php

declare(strict_types=1);

namespace Skeleton\Web\Component\Twig\Phoenix;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Tooltip
{
    public string $message = '';
    public string $icon = 'fas fa-question-circle text-body-tertiary ms-1';
    public string $placement = 'top';
}
