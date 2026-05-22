# Guidelines: Console Application (`apps/console`)

Этот файл действует для изменений внутри `apps/console`. Корневой `AGENTS.md` остаётся главным источником общих правил.

## Назначение

`apps/console` — CLI-приложение: Symfony console commands, maintenance entrypoints, cron/job entrypoints и worker-oriented orchestration.

Console слой не содержит business logic. Command собирает input/output, валидирует options/arguments, вызывает Application через bus и возвращает `Command::SUCCESS` / `Command::FAILURE`.

## Структура

```text
apps/console/src/Module/{ModuleName}/
├── Command/
│   └── {SubjectName}/
│       └── {ActionName}Command.php
├── Resource/config/services.yaml
└── {ModuleName}Module.php
```

## Commands

- Command должен быть тонким entrypoint.
- Используй `#[AsCommand(...)]` или service configuration, принятую в модуле.
- В `execute()` не размещай business logic, SQL, external API orchestration или сложные расчёты.
- Для use case вызывай `CommandBusComponentInterface` / `QueryBusComponentInterface`.
- Для long-running jobs предусматривай идемпотентность, логирование и понятные exit codes.
- Имена команд делай стабильными: `app:<module>:<action>` или project-specific convention после bootstrap.

## Tests

- App-specific console tests размещай в `apps/console/tests` с namespace `Skeleton\Console\Test\...`.
- Integration tests для command wiring/kernel behavior размещай в `apps/console/tests/Integration/Module/<ModuleName>`.
- Не используй реальные внешние сервисы или production DB в tests.
