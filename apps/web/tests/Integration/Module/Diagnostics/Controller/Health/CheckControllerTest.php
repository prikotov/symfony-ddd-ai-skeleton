<?php

declare(strict_types=1);

namespace Skeleton\Web\Test\Integration\Module\Diagnostics\Controller\Health;

use JsonException;
use Override;
use Skeleton\Common\Kernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class CheckControllerTest extends KernelTestCase
{
    /**
     * @throws JsonException
     */
    public function testInvokeWithWebKernelReturnsRuntimeDiagnostics(): void
    {
        $kernel = self::bootKernel();
        $request = Request::create('/health', Request::METHOD_GET);

        $response = $kernel->handle($request);
        $kernel->terminate($request, $response);

        self::assertSame(Response::HTTP_OK, $response->getStatusCode());
        self::assertSame('application/json', $response->headers->get('content-type'));

        /** @var array{status: string, entrypoint: string, app: string, environment: string, debug: bool, timezone: string, checkedAt: string} $payload */
        $payload = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertSame('ok', $payload['status']);
        self::assertSame('web-health', $payload['entrypoint']);
        self::assertSame('web', $payload['app']);
        self::assertSame('test', $payload['environment']);
        self::assertTrue($payload['debug']);
        self::assertSame('Asia/Novosibirsk', $payload['timezone']);
        self::assertNotSame('', $payload['checkedAt']);
    }

    #[Override]
    protected static function createKernel(array $options = []): KernelInterface
    {
        $_SERVER['APP_ENV'] = 'test';
        $_SERVER['APP_DEBUG'] = '1';
        $_SERVER['APP_SECRET'] = 'test';
        $_SERVER['DATABASE_URL'] = 'sqlite:///:memory:';
        $_SERVER['APP_CACHE_DIR'] = sys_get_temp_dir() . '/skeleton-tests/cache';
        $_SERVER['APP_LOG_DIR'] = sys_get_temp_dir() . '/skeleton-tests/log';

        return new Kernel('test', true, 'web');
    }
}
