<p align="center">
  <strong>Symfony DDD AI Skeleton</strong><br>
  Reusable Symfony 8 / PHP 8.4 skeleton for fast project starts with<br>
  modular DDD/CQRS, multi-application structure and AI-friendly workflow.
</p>

<p align="center">
  <a href="https://www.php.net/"><img src="https://img.shields.io/badge/PHP-8.4+-777BB4?logo=php&logoColor=white" alt="PHP 8.4+"></a>
  <a href="https://symfony.com/"><img src="https://img.shields.io/badge/Symfony-8.0-000000?logo=symfony&logoColor=white" alt="Symfony 8.0"></a>
  <img src="https://img.shields.io/badge/License-MIT-green" alt="MIT License">
</p>

---

## Why this skeleton?

Starting a new Symfony project with DDD and CQRS typically means hours of boilerplate: kernel configuration, module system, bus wiring, test setup, coding standard, CI pipeline and documentation conventions.

This skeleton provides all of that out of the box so you can focus on domain logic from day one.

**Key features:**

- **Multi-application kernel** — run Web, Console (and more) apps from a single repository, each with its own config, bundles and modules.
- **Modular DDD/CQRS** — every module follows Domain → Application → Infrastructure → Integration / Presentation layers with strict dependency direction enforced by Deptrac.
- **Module system** — register modules via simple config files; service auto-wiring, compiler passes and route loading are handled automatically.
- **AI-ready workflow** — `AGENTS.md` conventions, agent role system (`docs/agents/`), task tracking via `todo-md` and structured conventions give AI coding agents everything they need to work autonomously.
- **Quality gate** — `make check` runs syntax lint, codestyle, architecture analysis, doc validation, role validation and the full test suite.
- **Battle-tested conventions** — `docs/conventions/` covers layers, patterns, modules, testing and operations in detail.

---

## Quick start

### Requirements

- PHP ≥ 8.4
- [Composer](https://getcomposer.org/)
- `php-sqlite3` (for tests)

### Install

```bash
git clone https://github.com/prikotov/symfony-ddd-ai-skeleton.git my-project
cd my-project
make setup
```

`make setup` runs `composer install` followed by init scripts that populate `docs/conventions/`, `docs/git-workflow/`, `docs/todo-md/` and `todo/AGENTS.md` from vendor packages.

### Verify

```bash
make check
```

This runs: composer validate → lint → codestyle → doc validation → todo validation → role validation → deptrac → unit tests → integration tests.

### Example: console diagnostics

```bash
APP_ENV=test APP_DEBUG=1 APP_SECRET=test \
APP_CACHE_DIR=/tmp/skeleton-console-cache \
APP_LOG_DIR=/tmp/skeleton-console-log \
DATABASE_URL='sqlite:///:memory:' \
php bin/console app:diagnostics:runtime --id=console --no-interaction
```

### Example: web health endpoint

```bash
APP_ENV=test APP_DEBUG=1 APP_SECRET=test \
APP_CACHE_DIR=/tmp/skeleton-web-cache \
APP_LOG_DIR=/tmp/skeleton-web-log \
DATABASE_URL='sqlite:///:memory:' \
php -r '
  require "vendor/autoload.php";
  $k = new Skeleton\Common\Kernel("test", true, "web");
  $r = Symfony\Component\HttpFoundation\Request::create("/health", "GET");
  $resp = $k->handle($r);
  $k->terminate($r, $resp);
  $k->shutdown();
  echo $resp->getContent().PHP_EOL;
'
```

### Bootstrap your project

```bash
bin/bootstrap "MyVendor\\MyProject" my-vendor/my-project
```

This replaces the `Skeleton` namespace, package name and description across all PHP, config and documentation files.

---

## Architecture overview

```
├── src/                          # Common shared code
│   ├── Application/              #   CommandInterface, QueryInterface, DTO
│   ├── Component/                #   Module system, Event bus
│   ├── Exception/                #   Typed exception hierarchy
│   ├── Infrastructure/           #   CommandBus, QueryBus, EventBus implementations
│   ├── Module/                   #   Shared modules (Diagnostics, …)
│   └── Kernel.php                #   Multi-app kernel
│
├── apps/web/                     # Web application
│   ├── config/                   #   bundles, modules, packages, routes, services
│   ├── src/                      #   Controllers, Components, Web-specific modules
│   └── templates/                #   Twig templates
│
├── apps/console/                 # Console application
│   ├── config/
│   └── src/                      #   Console commands, Console-specific modules
│
├── config/                       # Common Symfony config
├── docs/                         # Conventions, agent roles, git workflow
├── tests/                        # Common Unit / Integration tests
├── migrations/                   # Doctrine migrations
└── todo/                         # Task tracking (todo-md)
```

### Layers inside a module

| Layer              | Responsibility                                               |
|--------------------|--------------------------------------------------------------|
| **Domain**         | Entities, value objects, domain services, repository interfaces |
| **Application**    | Use cases, commands, queries, handlers, DTO                  |
| **Infrastructure** | Persistence, cache, filesystem, external adapters            |
| **Integration**    | External API clients, cross-module listeners, middleware     |
| **Presentation**   | Controllers, console commands (call Application only)        |

### Request flow

```
Controller / Console Command
  → CommandBusComponentInterface / QueryBusComponentInterface
    → Command Handler / Query Handler
      → Domain services, Repositories
        → Infrastructure implementations
```

The bundled `Diagnostics` module documents the minimal read-only Query example:
[`docs/diagnostics-query-flow.md`](docs/diagnostics-query-flow.md).

---

## Module system

Modules are the primary building blocks. Each module:

- Lives under `src/Module/{Name}` (shared) or `apps/{app}/src/Module/{Name}` (app-specific).
- Implements `ModuleInterface`.
- Has `Resource/config/services.yaml` for service registration.
- Is registered in `config/modules.php` (shared) or `apps/{app}/config/modules.php`.

See the bundled `Diagnostics` module as a working example.

---

## Quality tooling

| Tool | Purpose |
|------|---------|
| `phpcs` + `Slevomat` + `prikotov/coding-standard` | Code style (PSR-12 + strict types, sorted uses) |
| `deptrac` | Architecture layer dependency enforcement |
| `phpunit` | Unit + Integration tests |
| `validate-md-links` | Documentation link consistency |
| `validate-docs` | Convention docs structure validation |
| `validate-roles` | Agent role file validation |
| `todo-md-validate` | Task tracking file validation |

Run everything at once:

```bash
make check
```

---

## AI agent workflow

This skeleton is built on the principles described in [**AI-Assisted Development Playbook**](https://github.com/prikotov/task-agents-playbook) — a public methodology for organizing AI-driven development with task-driven workflow, structured roles, conventions and quality gates.

Core components:

- **`AGENTS.md`** — rules, architecture summary, code style and safety constraints for AI agents.
- **`docs/agents/roles/team/`** — structured role definitions (team lead, architects, developers, devops, analysts, writers) that guide AI agents through specialized responsibilities.
- **`docs/conventions/`** — detailed conventions for every layer, pattern and operation so agents produce consistent code.
- **`todo/`** — `todo-md` task tracking with structured statuses, priorities and types.

When using AI coding agents (Claude, GPT, etc.), point them to `AGENTS.md` as the entry point — it references everything else.

---

## Associated packages

This skeleton depends on several purpose-built open-source packages:

| Package | Purpose |
|---------|---------|
| [prikotov/coding-standard](https://github.com/prikotov/coding-standard) | Conventions — coding standards, principles, patterns, layers and module structure for Symfony applications. Enforced via PHPCS, Deptrac, PHPStan |
| [prikotov/todo-md](https://github.com/prikotov/todo-md) | Task management system: tasks as Markdown files with YAML front matter, status changes via folder moves, templates for AI agents |
| [prikotov/git-workflow](https://github.com/prikotov/git-workflow) | Git workflow rules: branch naming, Conventional Commits, pull requests, code review, release and deploy |
| [prikotov/task-orchestrator](https://github.com/prikotov/task-orchestrator) | Console agent orchestrator: behavioral role profiles, skills, sub-agents in isolated context, YAML step chains, role validation |

---

## Documentation

- **Architecture & conventions** — [`docs/conventions/`](docs/conventions/)
- **Agent roles** — [`docs/agents/roles/team/`](docs/agents/roles/team/)
- **Git workflow** — [`docs/git-workflow/`](docs/git-workflow/)
- **UI components** — [`docs/ui/`](docs/ui/)
- **Task tracking** — [`docs/todo-md/`](docs/todo-md/)

---

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md).

---

## License

This project is licensed under the [MIT License](LICENSE).
