<?php

declare(strict_types=1);

namespace Skeleton\Web\Component\Twig\Phoenix;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class NavList
{
    public string $title = '';
    public string $icon;
    /**
     * @var array<int, array{
     *     label: string,
     *     url: string,
     *     description?: string|null,
     *     icon?: string|null,
     *     isNew?: bool
     * }>
     */
    public array $items = [];
    public string $parentId;

    public function __construct(
        private readonly RequestStack $requestStack,
    ) {
    }

    public function getId(): string
    {
        return 'nv-' . strtolower(str_replace(' ', '-', $this->title));
    }

    public function isAnyItemActive(): bool
    {
        $currentPath = $this->requestStack->getCurrentRequest()?->getPathInfo();

        foreach ($this->items as $item) {
            if (str_starts_with((string)$currentPath, $item['url'])) {
                return true;
            }
        }

        return false;
    }
}
