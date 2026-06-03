<?php

declare(strict_types=1);

namespace Skeleton\Web\Module\User\Controller\UserProfile;

use Skeleton\Common\Application\Component\QueryBus\QueryBusComponentInterface;
use Skeleton\Common\Module\User\Application\Dto\UserProfileDto;
use Skeleton\Common\Module\User\Application\Dto\UserProfileListDto;
use Skeleton\Common\Module\User\Application\UseCase\Query\UserProfile\ListUserProfiles\ListUserProfilesQuery;
use Skeleton\Web\Module\User\Route\UserProfileRoute;
use Skeleton\Web\Module\User\Security\UserProfile\ActionEnum as UserProfileActionEnum;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Twig\Environment;

#[Route(path: UserProfileRoute::LIST_PATH, name: UserProfileRoute::LIST, methods: [Request::METHOD_GET])]
#[IsGranted(UserProfileActionEnum::listProfiles->value)]
#[AsController]
final readonly class ListController
{
    public function __construct(
        private QueryBusComponentInterface $queryBus,
        private Environment $twig,
    ) {
    }

    public function __invoke(): Response
    {
        $userProfiles = $this->queryBus->query(new ListUserProfilesQuery(
            pagination: null,
            sort: [],
        ));

        return new Response($this->twig->render('@WebUser/user_profile/list.html.twig', [
            'userProfiles' => $this->normalize($userProfiles),
        ]));
    }

    /**
     * @return array{items: list<array{uuid: string, displayName: string, contactEmail: string, status: string, createdAt: string}>, total: int}
     */
    private function normalize(UserProfileListDto $userProfileList): array
    {
        $items = [];
        foreach ($userProfileList->items as $userProfile) {
            $items[] = $this->normalizeUserProfile($userProfile);
        }

        return [
            'items' => $items,
            'total' => $userProfileList->total,
        ];
    }

    /**
     * @return array{uuid: string, displayName: string, contactEmail: string, status: string, createdAt: string}
     */
    private function normalizeUserProfile(UserProfileDto $userProfile): array
    {
        return [
            'uuid' => $userProfile->uuid,
            'displayName' => $userProfile->displayName,
            'contactEmail' => $userProfile->contactEmail,
            'status' => $userProfile->status,
            'createdAt' => $userProfile->createdAt->format(DATE_ATOM),
        ];
    }
}
