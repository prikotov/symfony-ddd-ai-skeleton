<?php

declare(strict_types=1);

namespace Skeleton\Common\Test\Unit\Module\User\Integration\Service\RuntimeDiagnostics;

use DateTimeImmutable;
use LogicException;
use Override;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Skeleton\Common\Application\Component\QueryBus\QueryBusComponentInterface;
use Skeleton\Common\Application\Query\QueryInterface;
use Skeleton\Common\Module\Diagnostics\Application\Dto\RuntimeDiagnosticsDto;
use Skeleton\Common\Module\Diagnostics\Application\UseCase\Query\GetRuntimeDiagnostics\GetRuntimeDiagnosticsQuery;
use Skeleton\Common\Module\User\Domain\Service\RuntimeDiagnostics\GetRuntimeDiagnosticsSnapshotServiceInterface;
use Skeleton\Common\Module\User\Integration\Service\RuntimeDiagnostics\GetRuntimeDiagnosticsSnapshotService;

final class GetRuntimeDiagnosticsSnapshotServiceTest extends TestCase
{
    public function testGetUsesDiagnosticsQueryEntrypointAndMapsApplicationDto(): void
    {
        $checkedAt = new DateTimeImmutable('2026-06-02T12:34:56+00:00');
        $queryBus = new RuntimeDiagnosticsQueryBusStub(new RuntimeDiagnosticsDto(
            status: 'ok',
            entrypoint: 'user-integration-bridge',
            appId: 'console',
            environment: 'test',
            debug: true,
            timezone: 'Asia/Novosibirsk',
            checkedAt: $checkedAt,
        ));
        $service = new GetRuntimeDiagnosticsSnapshotService($queryBus);

        $snapshot = $service->get();

        self::assertInstanceOf(GetRuntimeDiagnosticsQuery::class, $queryBus->lastQuery);
        self::assertSame('user-integration-bridge', $queryBus->lastQuery->entrypoint);
        self::assertSame('ok', $snapshot->status);
        self::assertSame('user-integration-bridge', $snapshot->entrypoint);
        self::assertSame('console', $snapshot->appId);
        self::assertSame('test', $snapshot->environment);
        self::assertTrue($snapshot->debug);
        self::assertSame('Asia/Novosibirsk', $snapshot->timezone);
        self::assertSame('2026-06-02T12:34:56+00:00', $snapshot->checkedAt);
    }

    public function testGetThrowsWhenDiagnosticsQueryReturnsUnexpectedResult(): void
    {
        $queryBus = new UnexpectedResultQueryBusStub();
        $service = new GetRuntimeDiagnosticsSnapshotService($queryBus);

        self::expectException(LogicException::class);
        self::expectExceptionMessage(sprintf('Expected %s diagnostics query result.', RuntimeDiagnosticsDto::class));

        $service->get();
    }

    public function testServiceImplementsConsumerOwnedDomainContract(): void
    {
        self::assertContains(
            GetRuntimeDiagnosticsSnapshotServiceInterface::class,
            class_implements(GetRuntimeDiagnosticsSnapshotService::class),
        );
    }

    public function testServiceDoesNotDependOnDiagnosticsDomainOrInfrastructure(): void
    {
        $reflection = new ReflectionClass(GetRuntimeDiagnosticsSnapshotService::class);
        $fileName = $reflection->getFileName();

        self::assertIsString($fileName);

        $source = file_get_contents($fileName);

        self::assertIsString($source);
        self::assertStringNotContainsString('Skeleton\\Common\\Module\\Diagnostics\\Domain\\', $source);
        self::assertStringNotContainsString('Skeleton\\Common\\Module\\Diagnostics\\Infrastructure\\', $source);
    }
}

final class RuntimeDiagnosticsQueryBusStub implements QueryBusComponentInterface
{
    public ?QueryInterface $lastQuery = null;

    public function __construct(
        private RuntimeDiagnosticsDto $diagnostics,
    ) {
    }

    #[Override]
    public function query(QueryInterface $query)
    {
        $this->lastQuery = $query;

        return $this->diagnostics;
    }
}

final class UnexpectedResultQueryBusStub implements QueryBusComponentInterface
{
    #[Override]
    public function query(QueryInterface $query)
    {
        return new \stdClass();
    }
}
