# TODO: довести skeleton до нормального reusable template

## Обязательное перед широким переиспользованием

- [ ] Добавить GitHub Actions workflow, который запускает `make check` на каждом PR.
- [ ] Добавить project bootstrap command/script, который заменяет namespace `Skeleton` и package name на namespace нового проекта.
- [ ] Добавить генераторы/scaffold-команды:
  - [ ] common module: `src/Module/{ModuleName}`;
  - [ ] web module: `apps/web/src/Module/{ModuleName}`;
  - [ ] console module: `apps/console/src/Module/{ModuleName}`;
  - [ ] query + query handler + unit test;
  - [ ] command + command handler + unit test;
  - [ ] web controller + route class + integration test;
  - [ ] console command + integration test.
- [ ] Описать стабильный workflow создания нового модуля в `docs/`.
- [ ] Описать правила нейминга команд, routes, modules, services и tests отдельным short guide.
- [ ] Решить, нужен ли `Diagnostics` как постоянный example module или его лучше генерировать bootstrap-скриптом.

## Архитектура и DX

- [ ] Выделить базовый test kernel helper, чтобы tests не дублировали `createKernel()` и env-переменные.
- [ ] Добавить безопасный `.env.test` / test bootstrap для SQLite in-memory по умолчанию.
- [ ] Проверить, что module compiler pass корректно работает при десятках модулей и не даёт неочевидных ошибок.
- [ ] Добавить проверку, что каждый registered module имеет `Resource/config/services.yaml` или явно документированное отсутствие config.
- [ ] Подумать над `ModuleInterface` extensions для routes/templates/translations/assets, если web-модули будут активно расти.
- [ ] Добавить ADR по границам `Common`, `Web`, `Console` и shared modules.

## AI-разработка

- [ ] Сократить `AGENTS.md` до skeleton-level правил и вынести доменные safety overrides в отдельный template-файл.
- [ ] Сделать набор generic ролей без привязки к конкретной предметной области.
- [ ] Добавить инструкцию для AI: как переносить skeleton в новый проект и что обязательно заменить.
- [ ] Добавить checklist self-review для AI-generated PR.
- [ ] Добавить пример маленькой задачи в `todo/`, которую можно выполнить как smoke-test агентного workflow.

## Tooling

- [ ] Проверить, какие `prikotov/*` зависимости должны быть pinned к release tags, а какие можно оставлять на `dev-main`.
- [ ] Подготовить composer scripts для targeted checks: one unit test, one integration test, phpcs path, deptrac only.
- [ ] Добавить `make install` / `make bootstrap` с понятной семантикой для нового проекта.
- [ ] Добавить `make module` или Symfony console generator, если решим не использовать отдельный CLI.
- [ ] Решить, хранить ли `composer.lock` в skeleton или генерировать его при bootstrap нового проекта.

## Документация

- [ ] Добавить `docs/skeleton/quick-start.md`.
- [ ] Добавить `docs/skeleton/module-creation.md`.
- [ ] Добавить `docs/skeleton/testing.md`.
- [ ] Добавить `docs/skeleton/ai-workflow.md`.
- [ ] Добавить diagram для request flow: Web/Console → QueryBus/CommandBus → Application → Domain/Infrastructure.

## Production readiness нового проекта на базе skeleton

- [ ] Настроить secrets policy и правила `.env.local`/`.env.*.local`.
- [ ] Добавить real DB config только в конкретном проекте, не в skeleton.
- [ ] Добавить observability/logging conventions после выбора runtime-инфраструктуры.
- [ ] Добавить deploy/release workflow только после появления конкретного production target.
