<?php

declare(strict_types=1);

use Skeleton\Common\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

require_once dirname(__DIR__, 3) . '/vendor/autoload.php';

$projectDir = dirname(__DIR__, 3);
if (is_file($projectDir . '/.env')) {
    (new Dotenv())->bootEnv($projectDir . '/.env');
}

$kernel = new Kernel(
    $_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? 'dev',
    (bool) ($_SERVER['APP_DEBUG'] ?? $_ENV['APP_DEBUG'] ?? true),
    'web',
);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
