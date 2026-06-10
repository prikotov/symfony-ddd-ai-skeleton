<?php

declare(strict_types=1);

namespace Skeleton\Web\Test\Unit\Component\Sort;

use PHPUnit\Framework\TestCase;
use Skeleton\Web\Component\Sort\SortRequestDto;
use Symfony\Component\Validator\Validation;

final class SortRequestDtoTest extends TestCase
{
    public function testAllowsNullSort(): void
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $violations = $validator->validate(new SortRequestDto());

        self::assertCount(0, $violations);
    }

    public function testRejectsBlankSort(): void
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $violations = $validator->validate(new SortRequestDto(sort: ''));

        self::assertCount(1, $violations);
    }

    public function testKeepsProvidedSortValue(): void
    {
        $dto = new SortRequestDto(sort: '-displayName');

        self::assertSame('-displayName', $dto->sort);
    }
}
