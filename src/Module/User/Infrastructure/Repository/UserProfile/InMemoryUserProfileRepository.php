<?php

declare(strict_types=1);

namespace Skeleton\Common\Module\User\Infrastructure\Repository\UserProfile;

use DateTimeImmutable;
use InvalidArgumentException;
use Override;
use Skeleton\Common\Component\Repository\Enum\SortEnum;
use Skeleton\Common\Exception\ConfigurationException;
use Skeleton\Common\Module\User\Domain\Entity\UserProfileModel;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\Criteria\UserProfileFindCriteria;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\UserProfileCriteriaInterface;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\UserProfileRepositoryInterface;
use Symfony\Component\Uid\Uuid;

/**
 * Test-safe Infrastructure repository for the neutral User module example.
 *
 * It has no default users, credentials or external persistence. Projects that need real persistence should replace the
 * interface alias with their own Infrastructure implementation and migrations.
 */
final class InMemoryUserProfileRepository implements UserProfileRepositoryInterface
{
    /**
     * @var array<string, true> Explicit sort whitelist. No fallback sort is added implicitly.
     */
    private const array SORT_WHITELIST = [
        'contactEmail' => true,
        'createdAt' => true,
        'displayName' => true,
        'status' => true,
        'uuid' => true,
    ];

    /** @var array<string, UserProfileModel> */
    private array $storage = [];

    /**
     * @param iterable<UserProfileModel> $userProfiles
     */
    public function __construct(iterable $userProfiles = [])
    {
        foreach ($userProfiles as $userProfile) {
            $this->save($userProfile);
        }
    }

    #[Override]
    public function getByUuid(Uuid $uuid): ?UserProfileModel
    {
        return $this->storage[$uuid->toRfc4122()] ?? null;
    }

    #[Override]
    public function getOneByCriteria(UserProfileCriteriaInterface $criteria): ?UserProfileModel
    {
        $result = $this->getByCriteria($criteria);

        return $result[0] ?? null;
    }

    #[Override]
    public function getByCriteria(UserProfileCriteriaInterface $criteria): array
    {
        $findCriteria = $this->ensureFindCriteria($criteria);
        $result = $this->filterByCriteria($findCriteria);
        $result = $this->applySort($result, $findCriteria);

        return $this->applyPagination($result, $findCriteria);
    }

    #[Override]
    public function getCountByCriteria(UserProfileCriteriaInterface $criteria): int
    {
        return count($this->filterByCriteria($this->ensureFindCriteria($criteria)));
    }

    #[Override]
    public function save(UserProfileModel $userProfile): void
    {
        $this->storage[$userProfile->getUuid()->toRfc4122()] = $userProfile;
    }

    private function ensureFindCriteria(UserProfileCriteriaInterface $criteria): UserProfileFindCriteria
    {
        if (!$criteria instanceof UserProfileFindCriteria) {
            throw new ConfigurationException(sprintf('Unsupported user profile criteria: %s.', $criteria::class));
        }

        return $criteria;
    }

    /**
     * @return list<UserProfileModel>
     */
    private function filterByCriteria(UserProfileFindCriteria $criteria): array
    {
        $result = [];

        foreach ($this->storage as $userProfile) {
            if ($this->matchesCriteria($userProfile, $criteria)) {
                $result[] = $userProfile;
            }
        }

        return $result;
    }

    private function matchesCriteria(UserProfileModel $userProfile, UserProfileFindCriteria $criteria): bool
    {
        $status = $criteria->getStatus();
        if ($status !== null && $userProfile->getStatus() !== $status) {
            return false;
        }

        $search = $criteria->getSearch();
        if ($search === null) {
            return true;
        }

        $displayName = strtolower($userProfile->getDisplayName()->toString());
        $contactEmail = $userProfile->getContactEmail()->toString();

        return str_contains($displayName, $search) || str_contains($contactEmail, $search);
    }

    /**
     * @param list<UserProfileModel> $userProfiles
     * @return list<UserProfileModel>
     */
    private function applySort(array $userProfiles, UserProfileFindCriteria $criteria): array
    {
        $sort = $criteria->getSort();
        if ($sort === []) {
            return $userProfiles;
        }

        $this->assertSortWhitelisted($sort);

        usort(
            $userProfiles,
            function (UserProfileModel $left, UserProfileModel $right) use ($sort): int {
                foreach ($sort as $field => $direction) {
                    $comparison = $this->compareByField($left, $right, $field);
                    if ($comparison !== 0) {
                        return $direction === SortEnum::asc ? $comparison : -$comparison;
                    }
                }

                return 0;
            },
        );

        return array_values($userProfiles);
    }

    /**
     * @param array<string, SortEnum> $sort
     */
    private function assertSortWhitelisted(array $sort): void
    {
        foreach (array_keys($sort) as $field) {
            if (!isset(self::SORT_WHITELIST[$field])) {
                throw new InvalidArgumentException(sprintf(
                    'Sort field "%s" is not in the allowed list. Allowed fields: %s',
                    $field,
                    implode(', ', array_keys(self::SORT_WHITELIST)),
                ));
            }
        }
    }

    private function compareByField(UserProfileModel $left, UserProfileModel $right, string $field): int
    {
        return match ($field) {
            'contactEmail' => strcmp($left->getContactEmail()->toString(), $right->getContactEmail()->toString()),
            'createdAt' => $this->compareDateTime($left->getCreatedAt(), $right->getCreatedAt()),
            'displayName' => strcmp($left->getDisplayName()->toString(), $right->getDisplayName()->toString()),
            'status' => $left->getStatus()->value <=> $right->getStatus()->value,
            'uuid' => strcmp($left->getUuid()->toRfc4122(), $right->getUuid()->toRfc4122()),
            default => throw new InvalidArgumentException(sprintf('Unsupported sort field "%s".', $field)),
        };
    }

    private function compareDateTime(DateTimeImmutable $left, DateTimeImmutable $right): int
    {
        return $left->getTimestamp() <=> $right->getTimestamp();
    }

    /**
     * @param list<UserProfileModel> $userProfiles
     * @return list<UserProfileModel>
     */
    private function applyPagination(array $userProfiles, UserProfileFindCriteria $criteria): array
    {
        $offset = $criteria->getOffset();
        if ($offset !== null && $offset < 0) {
            throw new InvalidArgumentException('Criteria offset must not be negative.');
        }

        $limit = $criteria->getLimit();
        if ($limit !== null && $limit <= 0) {
            throw new InvalidArgumentException('Criteria limit must be greater than zero.');
        }

        if ($offset === null && $limit === null) {
            return $userProfiles;
        }

        return array_slice($userProfiles, $offset ?? 0, $limit);
    }
}
