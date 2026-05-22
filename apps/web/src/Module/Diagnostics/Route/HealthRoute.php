<?php

declare(strict_types=1);

namespace Skeleton\Web\Module\Diagnostics\Route;

use Symfony\Component\Routing\RouterInterface;

final readonly class HealthRoute
{
    public const string CHECK = 'web_health';
    public const string CHECK_PATH = '/health';

    public function __construct(
        private RouterInterface $router,
    ) {
    }

    public function check(): string
    {
        return $this->router->generate(self::CHECK);
    }
}
