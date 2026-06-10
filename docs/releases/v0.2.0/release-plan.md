# План релиза v0.2.0

## Метаданные

- Тег релиза: `v0.2.0`
- Линия релиза: `release/0.2`
- Исходная ветка: `master` (`b90b892fa3c9084073d85d1460f15e950a42e8d0`)
- Ответственный: Лид Арагорн (codex-cli)
- Плановая дата deploy: 2026-06-10

## Состав

- Включённые PR:
  - [PR #20](https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/20) — Use pagination and sort request mappers
- Включённые задачи:
  - [`TASK-skeleton-sort-request-dto`](../../../todo/done/TASK-skeleton-sort-request-dto.todo.md)
- Вне состава релиза:
  - UI controls для pagination/sort в Twig templates.
  - Новые Composer dependencies.
  - OpenAPI/Nelmio attributes.

## Риски

- Основные риски:
  - `composer release:minor` не выполнен из-за несовместимости `php-conventional-changelog` с текущим `Symfony Console 8`; release commit/tag подготовлены вручную.
  - Demo controller теперь применяет default pagination (`page=1`, `perPage=10`) вместо `null` pagination.
- Наличие миграций данных: нет.
- Порядок применения миграций: не требуется.
- Риск окна несовместимости: отсутствует, изменения не требуют БД/ENV/внешних сервисов.
- Замечания по обратной совместимости: публичных HTTP route changes нет; query params `page`, `perPage`, `sort` теперь обрабатываются в demo `UserProfile` list controller.

## Порядок deploy

1. Опубликовать git tag `v0.2.0`.
2. Опубликовать GitHub Release для `v0.2.0`.
3. Для проектов, использующих skeleton как upstream/reference, обновиться на tag `v0.2.0`.

## Проверки перед deploy

- [x] Тег релиза подготовлен локально после release commit.
- [x] `make check` выполнен успешно на `release/0.2`.
- [x] Миграции отсутствуют.
- [x] ENV changes отсутствуют.
- [x] `make tests-e2e` проверен и не запущен: target отсутствует в `Makefile`.

## Проверки после deploy

- Основные пользовательские сценарии:
  - `UserProfile` list page открывается без query params.
  - `UserProfile` list page принимает `page`, `perPage`, `sort` query params.
- Логи: проверить отсутствие ошибок HTTP 400/500 на demo list page.
- Очереди и воркеры: не затрагиваются.
- Build version и git SHA: `v0.2.0` / release tag SHA.

## Действия при проблеме после релиза

- Откат: не используется.
- Стратегия исправления: `hotfix` / `patch release` от `v0.2.0`.
- Ответственный инженер: Лид Арагорн (codex-cli).
- Канал коммуникации / задача: новая `todo/TASK-*` задача или GitHub issue.

## Заметки

- Release выполнен вручную, потому что `composer release:minor` завершился fatal error:
  `Declaration of ConventionalChangelog\\DefaultCommand::configure() must be compatible with Symfony\\Component\\Console\\Command\\Command::configure(): void`.
