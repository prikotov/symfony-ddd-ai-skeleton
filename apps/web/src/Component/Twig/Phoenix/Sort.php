<?php

declare(strict_types=1);

namespace Skeleton\Web\Component\Twig\Phoenix;

use InvalidArgumentException;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Sort
{
    private const string DIRECTION_ASC = 'asc';
    private const string DIRECTION_DESC = 'desc';

    public string $field;
    public string $label;
    public string $route;
    public int $page;
    public int $perPage;
    public ?string $currentSort = null;
    public string $defaultDirection = self::DIRECTION_ASC;
    public array $filter = [];

    public function isAsc(): bool
    {
        return $this->currentSort === $this->field;
    }

    public function isDesc(): bool
    {
        return $this->currentSort === '-' . $this->field;
    }

    public function nextSort(): string
    {
        if ($this->isAsc()) {
            return '-' . $this->field;
        }

        if ($this->isDesc()) {
            return $this->field;
        }

        return match ($this->defaultDirection) {
            self::DIRECTION_ASC => $this->field,
            self::DIRECTION_DESC => '-' . $this->field,
            default => throw new InvalidArgumentException(sprintf(
                'Unsupported sort default direction "%s".',
                $this->defaultDirection,
            )),
        };
    }
}
