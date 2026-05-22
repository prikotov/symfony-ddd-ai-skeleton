<?php

declare(strict_types=1);

namespace Skeleton\Web\Component\Twig\Phoenix;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class NavLink
{
    public string $title;
    public string $icon;
    public string $url;

    public function __construct(
        readonly private RequestStack $requestStack,
    ) {
    }

    public function isActive(): bool
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        return $currentRequest && $currentRequest->getPathInfo() === parse_url($this->url, PHP_URL_PATH);
    }
}
