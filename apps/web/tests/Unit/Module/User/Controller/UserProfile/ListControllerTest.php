<?php

declare(strict_types=1);

namespace Skeleton\Web\Test\Unit\Module\User\Controller\UserProfile;

use DateTimeImmutable;
use LogicException;
use Override;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Skeleton\Common\Application\Component\QueryBus\QueryBusComponentInterface;
use Skeleton\Common\Application\Query\QueryInterface;
use Skeleton\Common\Module\User\Application\Dto\UserProfileDto;
use Skeleton\Common\Module\User\Application\Dto\UserProfileListDto;
use Skeleton\Common\Module\User\Application\UseCase\Query\UserProfile\ListUserProfiles\ListUserProfilesQuery;
use Skeleton\Web\Module\User\Controller\UserProfile\ListController;
use Skeleton\Web\Module\User\Security\UserProfile\ActionEnum;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

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

    public function testInvokeRendersUserProfilesWithTwigTemplate(): void
    {
        $checkedAt = new DateTimeImmutable('2026-06-03T10:15:00+07:00');
        $queryBus = new QueryBusStub(new UserProfileListDto([
            new UserProfileDto(
                uuid: '2c8bd6dd-4c0d-4998-a489-3c1420a8f0ac',
                displayName: 'Ada Lovelace',
                contactEmail: 'ada@example.test',
                status: 'active',
                createdAt: $checkedAt,
            ),
        ], total: 1));
        $twig = new Environment(new ArrayLoader([
            '@WebUser/user_profile/list.html.twig' => '{{ userProfiles.total }}:{{ userProfiles.items[0].displayName }}:{{ userProfiles.items[0].createdAt }}',
        ]));
        $controller = new ListController($queryBus, $twig);

        $response = $controller();

        self::assertInstanceOf(Response::class, $response);
        self::assertInstanceOf(ListUserProfilesQuery::class, $queryBus->lastQuery);
        self::assertSame('1:Ada Lovelace:' . $checkedAt->format(DATE_ATOM), $response->getContent());
    }

    public function testInvokeWithUnexpectedQueryResultFailsFast(): void
    {
        $queryBus = new QueryBusStub(new \stdClass());
        $twig = new Environment(new ArrayLoader([
            '@WebUser/user_profile/list.html.twig' => 'unused',
        ]));
        $controller = new ListController($queryBus, $twig);

        self::expectException(LogicException::class);
        self::expectExceptionMessage(UserProfileListDto::class);

        $controller();
    }
}

final class QueryBusStub implements QueryBusComponentInterface
{
    public ?QueryInterface $lastQuery = null;

    public function __construct(
        private readonly mixed $result,
    ) {
    }

    #[Override]
    public function query(QueryInterface $query)
    {
        $this->lastQuery = $query;

        return $this->result;
    }
}
