<?php

declare(strict_types=1);

namespace Skeleton\Web\Component\Twig\Phoenix;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class DropdownActions
{
    /**
     * @var array<int, array<string, mixed>> Items configuration.
     *     Supported keys: label, url, method, icon, class, confirm, target, visible,
     *     divider, turbo, hiddenFields.
     */
    public array $items = [];

    public string $button = 'btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal';
    public string $icon = 'fas fa-ellipsis-h';
}
