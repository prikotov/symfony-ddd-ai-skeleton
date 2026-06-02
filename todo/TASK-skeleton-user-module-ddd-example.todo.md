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
pr:
status: in_progress
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
- [ ] Domain model/value objects/enums нейтральны и не содержат secrets/default credentials.
- [ ] Repository contract живёт в Domain, implementation — в Infrastructure.
- [ ] Criteria and pagination/sorting primitives используются безопасно.
- [ ] Application query возвращает DTO, а entrypoint не лезет напрямую в repository implementation.
- [ ] Unit/integration tests покрывают query/repository behavior с test doubles или test env.

### 🟡 Should Have (Желательно)
- [ ] Показать mapping и module resources через extension points.

### 🟢 Could Have (Опционально)
- [ ] Добавить small read-only list/detail example для web docs.

### ⚫ Won't Have (Не будем делать)
- [ ] Не делать полноценный RBAC/login/registration flow.

## 4. Implementation Plan (План реализации)
1. [ ] Проверить current User/module availability.
2. [ ] Спроектировать minimal neutral model and criteria.
3. [ ] Реализовать Domain/Application/Infrastructure slices.
4. [ ] Добавить tests and docs.
5. [ ] Запустить `make check`.

## 5. Definition of Done (Критерии приёмки)
- [ ] User module можно использовать как reference для нового bounded context.
- [ ] Нет production credentials/default users.
- [ ] Repository/criteria/pagination pattern применён и протестирован.
- [ ] `make check` проходит.

## 6. Verification (Самопроверка)
```bash
make check
```

## 7. Risks and Dependencies (Риски и зависимости)
- Риск спутать example User с готовой auth subsystem — явно подписать ограничения в docs.

## 8. Sources (Источники)
- [x] [Epic](EPIC-skeleton-module-ddd-scaffold.todo.md)
- [x] [Repository primitives task](done/TASK-skeleton-repository-criteria-pagination-sort.todo.md)
- [x] [Extension points task](done/TASK-skeleton-module-extension-points.todo.md)


## 9. Comments (Комментарии)
Задача заведена как часть epic approval PR. Перед передачей исполнителю тимлид должен создать task subbranch от epic branch и заполнить `assignee`, `branch`, `status: in_progress`.

## Инструкции для сабагента

**Ветка:** `task/skeleton-user-module-ddd-example` (уже создана и активна)
**PR:** будет создан как draft из `task/skeleton-user-module-ddd-example` в `epic/skeleton-module-ddd-scaffold`; после создания тимлид впишет ссылку.

### Порядок действий
1. Переключись в ветку `task/skeleton-user-module-ddd-example`: `git checkout task/skeleton-user-module-ddd-example`.
2. Реализуй задачу согласно описанию, epic boundaries и уже выполненным tasks.
3. Следуй [Конвенциям](../docs/conventions/index.md), `AGENTS.md` и [`todo/AGENTS.md`](AGENTS.md).
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
