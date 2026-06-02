---
type: feat
created: 2026-06-02
value: V4
complexity: C4
priority: P1
cost_plan:
cost_fact:
depends_on: TASK-skeleton-repository-criteria-pagination-sort, TASK-skeleton-module-extension-points
epic: EPIC-skeleton-module-ddd-scaffold
author: Лид Арагорн (codex-cli)
assignee: Бэкендер Левша (codex-cli)
branch: task/skeleton-user-module-ddd-example
pr: https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/15
status: done
---

# TASK-skeleton-user-module-ddd-example: Neutral User module DDD example

## 0. Простое описание (Human Brief)
### Проблема простыми словами (Problem)
- Skeleton нужен пример Domain model/repository/criteria/Infrastructure repository, но без production-auth assumptions.
- `User` удобен как нейтральный example, если не добавлять default credentials и project-specific roles.

### Варианты или путь решения (Solution Sketch)
- Выполнить задачу как самостоятельный slice эпика `EPIC-skeleton-module-ddd-scaffold`.
- Следовать границам эпика: переносить только generic skeleton patterns, не бизнес-домен.

### Ожидаемый результат (Expected Result)
- User example module показывает DDD/CQRS layers, repository contract и infrastructure implementation без секретов и production login flow.

## 1. Concept and Goal (Концепция и Цель)
### Story (Job Story)
> Когда я создаю новый Symfony DDD/CQRS проект из skeleton, я хочу иметь этот slice как проверенный reference, чтобы не копировать решения из бизнесового проекта вручную.

### Goal (Цель по SMART)
Добавить или усилить neutral User module example: Domain model/value objects/enums, criteria, repository interface, Infrastructure repository и Application query.

## 2. Context and Scope (Контекст и Границы)
*   **Где делаем:** `src/Module/User`, возможный web slice только если нужен для example, tests/docs.
*   **Текущее поведение:** User example может отсутствовать или быть недостаточно полным для module scaffold reference.
*   **Границы (Out of Scope):** Не создавать production authentication system, default users/passwords, migrations against real DB или domain-specific roles.

## 3. Requirements (Требования, MoSCoW)
### 🔴 Must Have (Обязательно)
- [x] Domain model/value objects/enums нейтральны и не содержат secrets/default credentials.
- [x] Repository contract живёт в Domain, implementation — в Infrastructure.
- [x] Criteria and pagination/sorting primitives используются безопасно.
- [x] Application query возвращает DTO, а entrypoint не лезет напрямую в repository implementation.
- [x] Unit/integration tests покрывают query/repository behavior с test doubles или test env.

### 🟡 Should Have (Желательно)
- [ ] Показать mapping и module resources через extension points.

### 🟢 Could Have (Опционально)
- [ ] Добавить small read-only list/detail example для web docs.

### ⚫ Won't Have (Не будем делать)
- [ ] Не делать полноценный RBAC/login/registration flow.

## 4. Implementation Plan (План реализации)
1. [x] Проверить current User/module availability.
2. [x] Спроектировать minimal neutral model and criteria.
3. [x] Реализовать Domain/Application/Infrastructure slices.
4. [x] Добавить tests and docs.
5. [x] Запустить `make check`.

## 5. Definition of Done (Критерии приёмки)
- [x] User module можно использовать как reference для нового bounded context.
- [x] Нет production credentials/default users.
- [x] Repository/criteria/pagination pattern применён и протестирован.
- [x] `make check` проходит.

## 6. Verification (Самопроверка)
```bash
make check
```

## 7. Risks and Dependencies (Риски и зависимости)
- Риск спутать example User с готовой auth subsystem — явно подписать ограничения в docs.

## 8. Sources (Источники)
- [x] [Epic](EPIC-skeleton-module-ddd-scaffold.todo.md)
- [x] [Repository primitives task](TASK-skeleton-repository-criteria-pagination-sort.todo.md)
- [x] [Extension points task](TASK-skeleton-module-extension-points.todo.md)


## 9. Comments (Комментарии)
Задача заведена как часть epic approval PR. Перед передачей исполнителю тимлид должен создать task subbranch от epic branch и заполнить `assignee`, `branch`, `status: in_progress`.

## Инструкции для сабагента

**Ветка:** `task/skeleton-user-module-ddd-example` (уже создана и активна)
**PR:** draft из `task/skeleton-user-module-ddd-example` в `epic/skeleton-module-ddd-scaffold` — [PR #15](https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/15).

### Порядок действий
1. Переключись в ветку `task/skeleton-user-module-ddd-example`: `git checkout task/skeleton-user-module-ddd-example`.
2. Реализуй задачу согласно описанию, epic boundaries и уже выполненным tasks.
3. Следуй [Конвенциям](../../docs/conventions/index.md), `AGENTS.md` и [`todo/AGENTS.md`](../AGENTS.md).
4. Создай minimal neutral `User` module example, а не production auth subsystem.
5. Обязательные границы: без default users/passwords, login/registration/RBAC, migrations для real DB, secrets, external services.
6. Repository contract должен жить в `Domain`, implementation — в `Infrastructure`; Application query возвращает DTO и не содержит business rules.
7. Используй уже добавленные repository primitives (`criteria`, `limit/offset`, safe sort whitelist`) только если это не раздувает slice.
8. Если нужна persistence demo, используй Doctrine mapping/resources безопасно и покрывай test env; не выполняй migrations.
9. После реализации запусти `make check`.
10. Сделай `git push`.
11. Переведи PR из draft в ready: `gh pr ready <PR_NUMBER>`.
12. Не трогай untracked `phpstan.neon.dist`; не переноси `Portfolio`/`TInvest`/broker/trading vocabulary в runtime skeleton.

## Change History (История изменений)
| Дата | Автор (роль) | Изменение |
| :--- | :--- | :--- |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создание задачи в рамках эпика `EPIC-skeleton-module-ddd-scaffold` |
| 2026-06-02 | Лид Арагорн (codex-cli) | Задача запущена по `epic-via-subagents`, подготовлена task branch |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создан draft PR #15 для реализации |
| 2026-06-02 | Бэкендер Левша (codex-cli) | Реализован neutral `UserProfile` module example, добавлены tests/docs, задача переведена в review |
| 2026-06-02 | Бэкендер Левша (codex-cli) | Закрыт change request external review: invalid sort direction теперь fail-fast через `SortableCriteriaTrait` |
| 2026-06-02 | Бэкендер Левша (codex-cli) | Повторный self-review после commit `4cecd93`: Approval |
| 2026-06-02 | Архитектор Локи (codex-cli) | Повторный adversarial external review PR #15: Approval |
| 2026-06-02 | Архитектор Гэндальф (codex-cli) | Повторный architecture external review PR #15: Approval |
| 2026-06-02 | Лид Арагорн (codex-cli) | Задача переведена в `done`, подготовлена к merge в epic branch |
