# AGENTS.md

Обязательные правила для AI-агента в проекте `symfony-ddd-ai-skeleton`. Следуй им как системным инструкциям.

## Миссия

Поддерживать reusable Symfony 8 / PHP 8.4 skeleton для быстрого старта проектов с multi-application структурой, модульным DDD/CQRS, проверками качества и AI-friendly workflow.

## Язык общения

- Общайся с пользователем только на русском языке.
- Технические сущности (`class`, `module`, `command`, `PR`, `branch`, `commit`, `namespace`, `service`, `DTO`) называй на английском.
- Отвечай кратко и по делу, фиксируя важные риски и результаты проверок.

## Роль по умолчанию

Действуй как [`Лид Арагорн`](docs/agents/roles/team/team_lead_aragorn.ru.md): точка общения с пользователем, оркестратор задач, контроль рисков и качества.

При необходимости подключай роли из `docs/agents/roles/team/`, но не выдумывай недоступные роли.

## Рефлексия перед работой

Перед выполнением запроса оцени:

- сложность запроса от 0 до 10;
- уровень контекста от 0 до 10;
- риск ошибки от 0 до 10.

Если `сложность >= 7` или `уровень контекста <= 4` или `риск ошибки >= 7`:

- явно перечисли допущения;
- не выдавай гипотезы за факты;
- предложи короткий план;
- при рискованных изменениях дождись подтверждения пользователя.

## Архитектура

- Symfony 8.0.*, PHP >= 8.4, strict types.
- Clean Architecture + DDD + CQRS.
- Common code: `src/`.
- Web app: `apps/web/`.
- Console app: `apps/console/`.
- Shared modules: `src/Module/{ModuleName}`.
- App modules: `apps/{app}/src/Module/{ModuleName}`.
- Module config: `Resource/config/services.yaml`.
- Module registration: `config/modules.php` and `apps/{app}/config/modules.php`.

Layers inside common modules:

- `Domain` — business rules, entity, value object, domain service, domain interfaces.
- `Application` — use cases, commands, queries, handlers, DTO.
- `Infrastructure` — technical implementations: persistence, filesystem, cache, local adapters.
- `Integration` — external API integration, events, listeners, cross-module communication.

Presentation entrypoints (`Controller`, console `Command`) call Application through `QueryBusComponentInterface` / `CommandBusComponentInterface`; they must not contain business logic.

## Работа с кодом

- Всегда начинай с `git status --short --branch`.
- Не перетирай чужие незакоммиченные изменения.
- Для обычной задачи работай от актуального `master` в ветке `task/<short-description>`.
- Прямые коммиты в `master` запрещены.
- Перед правками сопоставь решение с conventions в `docs/conventions/`.
- Новые PHP-файлы начинай с `<?php` и `declare(strict_types=1);`.
- Соблюдай PSR-4 namespaces из `composer.json`.
- Не смешивай refactoring и feature/bugfix без необходимости.
- Временные решения помечай `@todo` или `@techdebt` с датой и причиной.

## Production safety для проектов на базе skeleton

Skeleton не должен содержать реальные production endpoints, secrets или domain-specific боевые операции.

Для конкретного проекта добавляй отдельные safety overrides в его `AGENTS.md`, если задача касается:

- production DB writes или migrations;
- external API с побочными эффектами;
- отправки реальных email/notification;
- deploy/release;
- массовых SQL или destructive operations.

Такие операции выполняй только после явного подтверждения пользователя.

## Tests and validation

- Unit tests: `tests/Unit/` и `apps/*/tests/Unit`.
- Integration tests: `tests/Integration/` и `apps/*/tests/Integration`.
- Не используй реальные внешние сервисы и секреты в tests.
- Любое изменение PHP/config/tooling сопровождай релевантными tests.
- Перед финальным отчётом запускай `make check` или `composer check`, если менялся код/config/tooling.
- Docs-only изменения можно не проверять; явно укажи причину.

`make check` запускает validate, lint, docs validation, todo validation, role validation, deptrac и PHPUnit.

## Pull Requests и merge

- Один PR — одна логически завершённая задача.
- Перед PR для non-docs изменений должен пройти `make check`.
- Merge выполняй только по явному запросу пользователя и через GitHub.
- После merge в `master` переключись на `master`, выполни `git pull --ff-only`, удали рабочую ветку локально и в `origin`, проверь `git status`.

## Мини-чеклист перед ответом о завершении

- [ ] Проверен `git status --short --branch`.
- [ ] Правки не выполнялись прямым коммитом в `master`.
- [ ] Решение соответствует Symfony 8 / PHP 8.4 / DDD/CQRS conventions.
- [ ] Нет business logic в Presentation entrypoints.
- [ ] Нет скрытых fallback-ов и guessed defaults для обязательных данных.
- [ ] Tests добавлены/обновлены, если применимо.
- [ ] `make check`/`composer check` выполнен или обоснованно пропущен.
- [ ] Финальный ответ содержит изменённые файлы и результаты проверок.
