<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Component\Doctrine\Trait;

use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use Skeleton\Common\Component\Doctrine\Model\IdModelInterface;
use Skeleton\Common\Component\Doctrine\Trait\IdTrait;
use ValueError;

final class IdTraitTest extends TestCase
{
    public function testGetIdReturnsPersistedIdentifier(): void
    {
        $model = $this->createModel();
        $id = new ReflectionProperty($model, 'id');
        $id->setValue($model, 42);

        self::assertSame(42, $model->getId());
    }

    public function testGetIdBeforePersistenceThrowsValueError(): void
    {
        $model = $this->createModel();

        self::expectException(ValueError::class);
        self::expectExceptionMessage('Entity is not persisted yet.');

        $model->getId();
    }

    private function createModel(): IdModelInterface
    {
        return new class implements IdModelInterface {
            use IdTrait;
        };
    }
}
