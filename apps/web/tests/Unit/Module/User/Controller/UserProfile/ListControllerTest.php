<?php

declare(strict_types=1);

namespace Skeleton\Web\Test\Unit\Module\User\Controller\UserProfile;

use DateTimeImmutable;
use Override;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Skeleton\Common\Application\Component\QueryBus\QueryBusComponentInterface;
use Skeleton\Common\Application\Dto\PaginationDto;
use Skeleton\Common\Application\Mapper\SortDtoToOrderMapper;
use Skeleton\Common\Application\Query\QueryInterface;
use Skeleton\Common\Component\Repository\Enum\SortEnum;
use Skeleton\Common\Module\User\Application\Dto\UserProfileDto;
use Skeleton\Common\Module\User\Application\Dto\UserProfileListDto;
use Skeleton\Common\Module\User\Application\UseCase\Query\UserProfile\ListUserProfiles\ListUserProfilesQuery;
use Skeleton\Web\Component\Pagination\PaginationRequestDto;
use Skeleton\Web\Component\Pagination\PaginationRequestToApplicationDtoMapper;
use Skeleton\Web\Component\Sort\SortRequestDto;
use Skeleton\Web\Component\Sort\SortRequestToApplicationDtoMapper;
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
            '@web.user/user_profile/list.html.twig' => '{{ userProfiles.total }}:{{ userProfiles.items[0].displayName }}:{{ userProfiles.items[0].createdAt }}',
        ]));
        $controller = $this->createController($queryBus, $twig);

        $response = $controller();

        self::assertInstanceOf(Response::class, $response);
        self::assertInstanceOf(ListUserProfilesQuery::class, $queryBus->lastQuery);
        self::assertInstanceOf(PaginationDto::class, $queryBus->lastQuery->pagination);
        self::assertSame(10, $queryBus->lastQuery->pagination->limit);
        self::assertSame(0, $queryBus->lastQuery->pagination->offset);
        self::assertSame([], $queryBus->lastQuery->sort);
        self::assertSame('1:Ada Lovelace:' . $checkedAt->format(DATE_ATOM), $response->getContent());
    }

    public function testInvokeMapsSortRequestToListQuery(): void
    {
        $queryBus = new QueryBusStub(new UserProfileListDto([], total: 0));
        $twig = new Environment(new ArrayLoader([
            '@web.user/user_profile/list.html.twig' => '{{ userProfiles.total }}',
        ]));
        $controller = $this->createController($queryBus, $twig);

        $response = $controller->__invoke(sortRequestDto: new SortRequestDto(sort: '-displayName'));

        self::assertSame('0', $response->getContent());
        self::assertInstanceOf(ListUserProfilesQuery::class, $queryBus->lastQuery);
        self::assertSame(['displayName' => SortEnum::desc], $queryBus->lastQuery->sort);
    }

    public function testInvokeMapsPaginationRequestToListQuery(): void
    {
        $queryBus = new QueryBusStub(new UserProfileListDto([], total: 0));
        $twig = new Environment(new ArrayLoader([
            '@web.user/user_profile/list.html.twig' => '{{ pagination.page }}:{{ pagination.perPage }}:{{ userProfiles.total }}',
        ]));
        $controller = $this->createController($queryBus, $twig);

        $response = $controller(new PaginationRequestDto(page: 3, perPage: 25));

        self::assertSame('3:25:0', $response->getContent());
        self::assertInstanceOf(ListUserProfilesQuery::class, $queryBus->lastQuery);
        self::assertInstanceOf(PaginationDto::class, $queryBus->lastQuery->pagination);
        self::assertSame(25, $queryBus->lastQuery->pagination->limit);
        self::assertSame(50, $queryBus->lastQuery->pagination->offset);
    }

    private function createController(QueryBusComponentInterface $queryBus, Environment $twig): ListController
    {
        return new ListController(
            queryBus: $queryBus,
            twig: $twig,
            paginationRequestToApplicationDtoMapper: new PaginationRequestToApplicationDtoMapper(),
            sortRequestToApplicationDtoMapper: new SortRequestToApplicationDtoMapper(),
            sortDtoToOrderMapper: new SortDtoToOrderMapper(),
        );
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
