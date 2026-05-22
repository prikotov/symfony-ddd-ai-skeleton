<?php

declare(strict_types=1);

namespace Skeleton\Web\Component\Twig\Phoenix;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class ExternalLink
{
    public string $url;
    public int $limit = 50;

    public function getText(): string
    {
        return mb_strlen($this->url) > $this->limit
            ? mb_substr($this->url, 0, $this->limit) . '...'
            : $this->url;
    }
}
