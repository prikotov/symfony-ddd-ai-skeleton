<?php

declare(strict_types=1);

namespace Skeleton\Web\Component\Twig\Phoenix;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Badge
{
    public const string PRIMARY = 'primary';
    public const string SECONDARY = 'secondary';
    public const string SUCCESS = 'success';
    public const string INFO = 'info';
    public const string WARNING = 'warning';
    public const string DANGER = 'danger';
    public const string LIGHT = 'light';
    public const string DARK = 'dark';

    public const string VARIANT_PHOENIX = 'phoenix';
    public const string VARIANT_BOOTSTRAP = 'bootstrap';

    public string $type = self::PRIMARY;
    public string $variant = self::VARIANT_PHOENIX;
    public ?string $id = null;
    public string $text;
    public ?string $title = null;
    public ?string $class = null;
    public string $pill = 'false';

    public function badgeClass(): string
    {
        if ($this->variant === self::VARIANT_BOOTSTRAP) {
            $classes = ['badge'];
            if (filter_var($this->pill, FILTER_VALIDATE_BOOLEAN)) {
                $classes[] = 'rounded-pill';
            }

            $classes[] = 'text-bg-' . $this->type;

            return implode(' ', $classes);
        }

        return 'badge badge-phoenix fs-10 badge-phoenix-' . $this->type;
    }
}
