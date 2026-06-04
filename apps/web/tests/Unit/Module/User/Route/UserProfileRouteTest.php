<?php

declare(strict_types=1);

namespace Skeleton\Web\Test\Unit\Module\User\Route;

use PHPUnit\Framework\TestCase;
use Skeleton\Web\Module\User\Route\UserProfileRoute;
use Symfony\Component\Routing\RouterInterface;

final class UserProfileRouteTest extends TestCase
{
    public function testListGeneratesUserProfileListRoute(): void
    {
        self::assertSame('user_profile_list', UserProfileRoute::LIST);

        $router = $this->createMock(RouterInterface::class);
        $router
            ->expects(self::once())
            ->method('generate')
            ->with(UserProfileRoute::LIST)
            ->willReturn(UserProfileRoute::LIST_PATH);

        $route = new UserProfileRoute($router);

        self::assertSame(UserProfileRoute::LIST_PATH, $route->list());
    }
}
