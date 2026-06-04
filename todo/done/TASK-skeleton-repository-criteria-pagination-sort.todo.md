---
type: feat
created: 2026-06-02
value: V4
complexity: C4
priority: P1
cost_plan:
cost_fact:
depends_on: TASK-skeleton-patterns-inventory
epic: EPIC-skeleton-module-ddd-scaffold
author: Лид Арагорн (codex-cli)
assignee: Бэкендер Левша (codex-cli)
branch: task/skeleton-repository-criteria-pagination-sort
pr: https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/13
status: done
---

# TASK-skeleton-repository-criteria-pagination-sort: Repository criteria, pagination and sort primitives

## 0. Простое описание (Human Brief)
### Проблема простыми словами (Problem)
- Repository criteria, pagination и sorting часто повторяются в проектах, но без skeleton primitives каждый модуль изобретает свои DTO/traits.
- Sorting из request опасен без whitelist allowed fields.

### Варианты или путь решения (Solution Sketch)
- Выполнить задачу как самостоятельный slice эпика `EPIC-skeleton-module-ddd-scaffold`.
- Следовать границам эпика: переносить только generic skeleton patterns, не бизнес-домен.

### Ожидаемый результат (Expected Result)
- В skeleton есть reusable primitives и пример безопасного sort whitelist перед Doctrine criteria.

## 1. Concept and Goal (Концепция и Цель)
### Story (Job Story)
> Когда я создаю новый Symfony DDD/CQRS проект из skeleton, я хочу иметь этот slice как проверенный reference, чтобы не копировать решения из бизнесового проекта вручную.

### Goal (Цель по SMART)
Добавить generic repository criteria/pagination/sorting primitives и tests, не привязанные к бизнес-домену.

## 2. Context and Scope (Контекст и Границы)
*   **Где делаем:** `src/Component`, `src/Infrastructure`, tests; точные namespaces выбрать по conventions.
*   **Текущее поведение:** В `stocks2` есть reusable подходы, но skeleton ещё не фиксирует canonical primitives.
*   **Границы (Out of Scope):** Не переносить portfolio-specific filters, Yii2 DB assumptions или бизнесовые read models.

## 3. Requirements (Требования, MoSCoW)
### 🔴 Must Have (Обязательно)
- [x] Добавить generic pagination DTO/request mapper или equivalent primitive.
- [x] Добавить sort mapper с whitelist allowed fields.
- [x] Добавить criteria interfaces/value objects без business vocabulary.
- [x] Покрыть edge cases: unknown sort field, default page/limit policy, stable ordering.

### 🟡 Should Have (Желательно)
- [x] Документировать пример использования в repository implementation.

### 🟢 Could Have (Опционально)
- [ ] Добавить small fixture/demo repository для тестов.

### ⚫ Won't Have (Не будем делать)
- [ ] Не добавлять GraphQL/API Platform-specific pagination в этот slice.

## 4. Implementation Plan (План реализации)
1. [x] Проверить inventory и существующие skeleton components.
2. [x] Спроектировать минимальный набор classes/interfaces.
3. [x] Реализовать primitives и tests.
4. [x] Связать с Health/User examples только если это не утяжеляет slice.
5. [x] Запустить `make check`.

## 5. Definition of Done (Критерии приёмки)
- [x] Sort whitelist обязателен перед применением к Doctrine/query builder.
- [x] Primitives имеют нейтральные names и строгую типизацию.
- [x] Unit tests покрывают основные edge cases.
- [x] `make check` проходит.

## 6. Verification (Самопроверка)
```bash
make check
```

## 7. Risks and Dependencies (Риски и зависимости)
- Риск overengineering abstract base classes — держать primitives маленькими и composable.

## 8. Sources (Источники)
- [x] [Epic](EPIC-skeleton-module-ddd-scaffold.todo.md)
- [x] [Inventory task](TASK-skeleton-patterns-inventory.todo.md)


## 9. Comments (Комментарии)
Задача заведена как часть epic approval PR. Перед передачей исполнителю тимлид должен создать task subbranch от epic branch и заполнить `assignee`, `branch`, `status: in_progress`.

## Инструкции для сабагента

**Ветка:** `task/skeleton-repository-criteria-pagination-sort` (уже создана и активна)
**PR:** draft из `task/skeleton-repository-criteria-pagination-sort` в `epic/skeleton-module-ddd-scaffold` — [PR #13](https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/13).

### Порядок действий
1. Переключись в ветку `task/skeleton-repository-criteria-pagination-sort`: `git checkout task/skeleton-repository-criteria-pagination-sort`.
2. Реализуй задачу согласно описанию, epic boundaries и inventory.
3. Следуй [Конвенциям](../../docs/conventions/index.md), `AGENTS.md` и [`todo/AGENTS.md`](../AGENTS.md).
4. Делай промежуточные commits после логического этапа.
5. После реализации запусти `make check`.
6. Сделай `git push`.
7. Переведи PR из draft в ready: `gh pr ready <PR_NUMBER>`.
8. Не трогай untracked `phpstan.neon.dist`; не переноси `Portfolio`/`TInvest`/broker/trading vocabulary в runtime skeleton.
9. Sort whitelist должен быть обязательным перед применением sort к Doctrine criteria/query builder.

## Known Divergences

### Generated conventions vs tracked PR artifacts

`docs/conventions/` is copied from `prikotov/coding-standard` by init scripts and is ignored by `docs/.gitignore`; changes inside that directory do not become PR artifacts in this repository.

The tracked usage example for this slice lives in `src/Component/Repository/Criteria/Mapper/LimitOffsetSortCriteriaMapper.php` PHPDoc and demonstrates mandatory `SORT_WHITELIST` usage:

```php
$doctrineCriteria = $this->limitOffsetSortMapper->map($criteria, self::SORT_WHITELIST);
```

@todo 2026-06-02 Update vendor package `prikotov/coding-standard`: examples in `docs/conventions/layers/infrastructure/criteria-mapper.md` must pass explicit allowed sort fields to `LimitOffsetSortCriteriaMapper::map($criteria, self::SORT_WHITELIST)`.

## Change History (История изменений)
| Дата | Автор (роль) | Изменение |
| :--- | :--- | :--- |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создание задачи в рамках эпика `EPIC-skeleton-module-ddd-scaffold` |
| 2026-06-02 | Лид Арагорн (codex-cli) | Задача запущена по `epic-via-subagents`, подготовлена task branch |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создан draft PR #13 для реализации |
| 2026-06-02 | Бэкендер Левша (codex-cli) | Self-review CR: conventions generated docs не попадают в PR; tracked example зафиксирован в PHPDoc, добавлен `@todo` на vendor package; stable ordering test усилен |
| 2026-06-02 | Бэкендер Левша (codex-cli) | Повторный self-review после commit `3106526`: Approval |
| 2026-06-02 | Архитектор Локи (codex-cli) | External review PR #13: Approval |
| 2026-06-02 | Лид Арагорн (codex-cli) | Задача переведена в `done`, подготовлена к merge в epic branch |
