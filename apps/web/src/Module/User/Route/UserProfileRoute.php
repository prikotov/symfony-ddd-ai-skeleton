<?php

declare(strict_types=1);

namespace Skeleton\Web\Module\User\Route;

use Symfony\Component\Routing\RouterInterface;

final readonly class UserProfileRoute
{
    public const string LIST = 'user_profile_list';
    public const string LIST_PATH = '/user-profiles';

    public function __construct(
        private RouterInterface $router,
    ) {
    }

    public function list(): string
    {
        return $this->router->generate(self::LIST);
    }
}
