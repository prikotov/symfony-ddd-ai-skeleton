<?php

declare(strict_types=1);

namespace Skeleton\Web\Test\Unit\Module\User\Controller\UserProfile;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Skeleton\Web\Module\User\Controller\UserProfile\ListController;
use Skeleton\Web\Module\User\Security\UserProfile\ActionEnum;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ListControllerTest extends TestCase
{
    public function testControllerUsesActionEnumForIsGrantedAttribute(): void
    {
        $reflection = new ReflectionClass(ListController::class);
        $attributes = $reflection->getAttributes(IsGranted::class);

        self::assertCount(1, $attributes);

        $isGranted = $attributes[0]->newInstance();

        self::assertSame(ActionEnum::listProfiles->value, $isGranted->attribute);
        self::assertNull($isGranted->subject);
    }
}
