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
assignee:
branch:
pr:
status: todo
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
- [ ] Сохранить `/health` или equivalent endpoint read-only и dependency-light.
- [ ] Показать Query, QueryHandler, DTO/result pattern.
- [ ] Проверить route/controller entrypoint обращается к Application, не к Domain/Infrastructure напрямую.
- [ ] Добавить/обновить tests.

### 🟡 Should Have (Желательно)
- [ ] Документировать Health as simplest module example.

### 🟢 Could Have (Опционально)
- [ ] Добавить Diagnostics page/template только если уже есть web baseline и это не расширяет scope.

### ⚫ Won't Have (Не будем делать)
- [ ] Не делать readiness checks реальных внешних сервисов.

## 4. Implementation Plan (План реализации)
1. [ ] Проверить текущий Diagnostics code path.
2. [ ] Привести к minimal Query use case при необходимости.
3. [ ] Добавить tests и docs comments.
4. [ ] Запустить `make check`.

## 5. Definition of Done (Критерии приёмки)
- [ ] Health/Diagnostics flow является canonical minimal Query example.
- [ ] Endpoint не требует auth и не выполняет side effects.
- [ ] Tests покрывают happy path.
- [ ] `make check` проходит.

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

## Change History (История изменений)
| Дата | Автор (роль) | Изменение |
| :--- | :--- | :--- |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создание задачи в рамках эпика `EPIC-skeleton-module-ddd-scaffold` |
