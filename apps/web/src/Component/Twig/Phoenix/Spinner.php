<?php

declare(strict_types=1);

namespace Skeleton\Web\Component\Twig\Phoenix;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Spinner
{
    public const string PRIMARY = 'primary';
    public const string SECONDARY = 'secondary';
    public const string SUCCESS = 'success';
    public const string INFO = 'info';
    public const string WARNING = 'warning';
    public const string DANGER = 'danger';

    public const string BORDER = 'border';
    public const string GROW = 'grow';

    public ?string $type = null;
    public string $style = self::BORDER;
    public string $text = 'Loading...';
    public bool $small = false;

    public function mount(string $small = 'false'): void
    {
        $this->small = filter_var($small, FILTER_VALIDATE_BOOLEAN);
    }
}
