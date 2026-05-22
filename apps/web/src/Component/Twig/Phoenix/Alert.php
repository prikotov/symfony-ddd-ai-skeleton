<?php

declare(strict_types=1);

namespace Skeleton\Web\Component\Twig\Phoenix;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Alert
{
    public const string PRIMARY = 'primary';
    public const string SECONDARY = 'secondary';
    public const string SUCCESS = 'success';
    public const string DANGER = 'danger';
    public const string WARNING = 'warning';
    public const string INFO = 'info';
    public const string LIGHT = 'light';
    public const string DARK = 'dark';

    public const string VARIANT_OUTLINE = 'outline';
    public const string VARIANT_PHOENIX = 'phoenix';
    public const string VARIANT_SOLID = 'solid';
    public const string VARIANT_SUBTLE = 'subtle';

    public string $type = self::PRIMARY;
    public string $variant = self::VARIANT_OUTLINE;

    public string $message = '';

    public bool $dismissible = true;

    public bool $showIcon = true;

    public function alertClass(): string
    {
        return match ($this->variant) {
            self::VARIANT_PHOENIX => 'alert alert-phoenix-' . $this->type,
            self::VARIANT_SOLID => 'alert alert-' . $this->type,
            self::VARIANT_SUBTLE => 'alert alert-subtle-' . $this->type,
            default => 'alert alert-outline-' . $this->type,
        };
    }

    public function iconClass(string $type): string
    {
        return match ($type) {
            self::SUCCESS => 'fa-check-circle text-success',
            self::DANGER, 'error' => 'fa-times-circle text-danger',
            self::WARNING => 'fa-info-circle text-warning',
            self::INFO => 'fa-info-circle text-info',
            self::PRIMARY, self::SECONDARY, self::LIGHT, self::DARK => 'fa-info-circle text-' . $type,
            default => 'fa-info-circle text-info',
        };
    }
}
