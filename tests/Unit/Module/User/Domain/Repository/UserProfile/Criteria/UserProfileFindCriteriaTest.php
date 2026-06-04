<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Module\User\Domain\Repository\UserProfile\Criteria;

use PHPUnit\Framework\TestCase;
use Skeleton\Common\Module\User\Domain\Repository\UserProfile\Criteria\UserProfileFindCriteria;

final class UserProfileFindCriteriaTest extends TestCase
{
    public function testSetSearchTrimsSearchWithoutChangingCase(): void
    {
        $criteria = new UserProfileFindCriteria(search: '  Ada  ');

        self::assertSame('Ada', $criteria->getSearch());
    }

    public function testSetSearchWithBlankValueResetsSearch(): void
    {
        $criteria = new UserProfileFindCriteria(search: 'Ada');

        $criteria->setSearch('   ');

        self::assertNull($criteria->getSearch());
    }
}
