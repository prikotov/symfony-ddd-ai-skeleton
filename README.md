# symfony-ddd-ai-skeleton

Reusable Symfony 8 / PHP 8.4 skeleton for AI-assisted development with modular DDD/CQRS and multiple application entrypoints.

## What is included

- Common code and shared modules: `src/`
- Web application: `apps/web/`
- Console application: `apps/console/`
- Module registration via `config/modules.php` and `apps/*/config/modules.php`
- CQRS entrypoints: `CommandBus`, `QueryBus`, `EventBus`
- Example read-only `Diagnostics` module
- App-specific tests under `apps/*/tests`
- Project conventions and AI-agent rules in `AGENTS.md`, `docs/conventions/`, `docs/agents/`

## Quick start

```bash
composer install
make check
```

Run the example console diagnostic:

```bash
APP_ENV=test APP_DEBUG=1 APP_SECRET=test \
APP_CACHE_DIR=/tmp/skeleton-console-cache \
APP_LOG_DIR=/tmp/skeleton-console-log \
DATABASE_URL='sqlite:///:memory:' \
php bin/console app:diagnostics:runtime --id=console --no-interaction
```

Run the example web health endpoint through the kernel:

```bash
APP_ENV=test APP_DEBUG=1 APP_SECRET=test \
APP_CACHE_DIR=/tmp/skeleton-web-cache \
APP_LOG_DIR=/tmp/skeleton-web-log \
DATABASE_URL='sqlite:///:memory:' \
php -r 'require "vendor/autoload.php"; $kernel = new Skeleton\\Common\\Kernel("test", true, "web"); $request = Symfony\\Component\\HttpFoundation\\Request::create("/health", "GET"); $response = $kernel->handle($request); $kernel->terminate($request, $response); $kernel->shutdown(); echo $response->getContent().PHP_EOL;'
```

## Next steps

See [TODO.md](TODO.md) before using this repository as a production template.
