---
type: feat
created: 2026-06-02
value: V3
complexity: C3
priority: P1
cost_plan:
cost_fact:
depends_on: TASK-skeleton-module-extension-points
epic: EPIC-skeleton-module-ddd-scaffold
author: Лид Арагорн (codex-cli)
assignee: Бэкендер Тони (codex-cli)
branch: task/skeleton-health-query-example
pr: https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/14
status: review
---

# TASK-skeleton-health-query-example: Health/Diagnostics read-only query example

## 0. Простое описание (Human Brief)
### Проблема простыми словами (Problem)
- Нужен короткий canonical example Application Query flow без бизнес-домена.
- Health/Diagnostics подходит как безопасный read-only пример, но его нельзя утяжелять auth или external calls.

### Варианты или путь решения (Solution Sketch)
- Выполнить задачу как самостоятельный slice эпика `EPIC-skeleton-module-ddd-scaffold`.
- Следовать границам эпика: переносить только generic skeleton patterns, не бизнес-домен.

### Ожидаемый результат (Expected Result)
- Health/Diagnostics демонстрирует Presentation → Application Query → DTO flow и остаётся маленьким read-only endpoint/use case.

## 1. Concept and Goal (Концепция и Цель)
### Story (Job Story)
> Когда я создаю новый Symfony DDD/CQRS проект из skeleton, я хочу иметь этот slice как проверенный reference, чтобы не копировать решения из бизнесового проекта вручную.

### Goal (Цель по SMART)
Оформить Health/Diagnostics как минимальный read-only Application Query example со слоями, docs и tests.

## 2. Context and Scope (Контекст и Границы)
*   **Где делаем:** `src/Module/Diagnostics`, `apps/web/src/Module/Diagnostics`, tests/docs.
*   **Текущее поведение:** В skeleton есть Diagnostics, но canonical CQRS layering может быть неполным или не описанным.
*   **Границы (Out of Scope):** Не добавлять auth dependency для `/health`, DB writes, external probes или production secrets.

## 3. Requirements (Требования, MoSCoW)
### 🔴 Must Have (Обязательно)
- [x] Сохранить `/health` или equivalent endpoint read-only и dependency-light.
- [x] Показать Query, QueryHandler, DTO/result pattern.
- [x] Проверить route/controller entrypoint обращается к Application, не к Domain/Infrastructure напрямую.
- [x] Добавить/обновить tests.

### 🟡 Should Have (Желательно)
- [x] Документировать Health as simplest module example.

### 🟢 Could Have (Опционально)
- [ ] Добавить Diagnostics page/template только если уже есть web baseline и это не расширяет scope.

### ⚫ Won't Have (Не будем делать)
- [ ] Не делать readiness checks реальных внешних сервисов.

## 4. Implementation Plan (План реализации)
1. [x] Проверить текущий Diagnostics code path.
2. [x] Привести к minimal Query use case при необходимости.
3. [x] Добавить tests и docs comments.
4. [x] Запустить `make check`.

## 5. Definition of Done (Критерии приёмки)
- [x] Health/Diagnostics flow является canonical minimal Query example.
- [x] Endpoint не требует auth и не выполняет side effects.
- [x] Tests покрывают happy path.
- [x] `make check` проходит.

## 6. Verification (Самопроверка)
```bash
make check
```

## 7. Risks and Dependencies (Риски и зависимости)
- Риск превратить Health в мониторинг всех подсистем — оставить advanced checks out of scope.

## 8. Sources (Источники)
- [x] [Epic](EPIC-skeleton-module-ddd-scaffold.todo.md)
- [x] [Extension points task](done/TASK-skeleton-module-extension-points.todo.md)


## 9. Comments (Комментарии)
Задача заведена как часть epic approval PR. Перед передачей исполнителю тимлид должен создать task subbranch от epic branch и заполнить `assignee`, `branch`, `status: in_progress`.

## Инструкции для сабагента

**Ветка:** `task/skeleton-health-query-example` (уже создана и активна)
**PR:** draft из `task/skeleton-health-query-example` в `epic/skeleton-module-ddd-scaffold` — [PR #14](https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/14).

### Порядок действий
1. Переключись в ветку `task/skeleton-health-query-example`: `git checkout task/skeleton-health-query-example`.
2. Реализуй задачу согласно описанию, epic boundaries и уже выполненным tasks.
3. Следуй [Конвенциям](../docs/conventions/index.md), `AGENTS.md` и [`todo/AGENTS.md`](AGENTS.md).
4. Health/Diagnostics должен остаться read-only, dependency-light, без auth, external probes, DB writes и production secrets.
5. Entry points (`Controller`, console `Command`) должны обращаться в Application Query через QueryBus, не в Domain/Infrastructure напрямую.
6. Если текущая реализация уже соответствует требованиям, сделай минимальные улучшения: документационный reference, тестовые assertions или small cleanup без overengineering.
7. После реализации запусти `make check`.
8. Сделай `git push`.
9. Переведи PR из draft в ready: `gh pr ready <PR_NUMBER>`.
10. Не трогай untracked `phpstan.neon.dist`; не переноси `Portfolio`/`TInvest`/broker/trading vocabulary в runtime skeleton.

## Change History (История изменений)
| Дата | Автор (роль) | Изменение |
| :--- | :--- | :--- |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создание задачи в рамках эпика `EPIC-skeleton-module-ddd-scaffold` |
| 2026-06-02 | Лид Арагорн (codex-cli) | Задача запущена по `epic-via-subagents`, подготовлена task branch |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создан draft PR #14 для реализации |
| 2026-06-02 | Бэкендер Тони (codex-cli) | Добавлен reference для Diagnostics Query flow, контрактные PHPDoc и точечные assertions |
| 2026-06-02 | Бэкендер Тони (codex-cli) | Закрыт change request external review: усилена проверка `checkedAt` parse errors и round-trip |
