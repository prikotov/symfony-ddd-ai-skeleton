---
type: feat
created: 2026-06-02
value: V3
complexity: C3
priority: P1
cost_plan:
cost_fact:
depends_on: TASK-skeleton-user-module-ddd-example
epic: EPIC-skeleton-module-ddd-scaffold
author: Лид Арагорн (codex-cli)
assignee:
branch:
pr:
status: todo
---

# TASK-skeleton-presentation-security-pattern: Presentation security pattern example

## 0. Простое описание (Human Brief)
### Проблема простыми словами (Problem)
- В проектах повторяется pattern Route/Role/Action/Permission/Grant/Rule/Voter, но в skeleton нет нейтрального reference.
- Нужно показать проверку прав в Presentation без business-specific permissions.

### Варианты или путь решения (Solution Sketch)
- Выполнить задачу как самостоятельный slice эпика `EPIC-skeleton-module-ddd-scaffold`.
- Следовать границам эпика: переносить только generic skeleton patterns, не бизнес-домен.

### Ожидаемый результат (Expected Result)
- Skeleton содержит маленький нейтральный security example, который можно копировать и адаптировать в проекте-потомке.

## 1. Concept and Goal (Концепция и Цель)
### Story (Job Story)
> Когда я создаю новый Symfony DDD/CQRS проект из skeleton, я хочу иметь этот slice как проверенный reference, чтобы не копировать решения из бизнесового проекта вручную.

### Goal (Цель по SMART)
Добавить neutral Presentation security pattern на примере User/demo module: route constants/generator, action, permission, grant/rule/voter.

## 2. Context and Scope (Контекст и Границы)
*   **Где делаем:** `apps/web/src/Module/User` или demo module, security tests/docs.
*   **Текущее поведение:** Pattern был замечен в `stocks2`, но skeleton не должен копировать portfolio-specific names.
*   **Границы (Out of Scope):** Object-level ACL и сложный RBAC оставить future slice; не добавлять production roles.

## 3. Requirements (Требования, MoSCoW)
### 🔴 Must Have (Обязательно)
- [ ] Route constants/generator pattern нейтрален и documented.
- [ ] Action/Permission enums не используют investment vocabulary.
- [ ] Grant/Rule/Voter отделены от controller logic.
- [ ] Tests покрывают allow/deny behavior на минимальном сценарии.

### 🟡 Should Have (Желательно)
- [ ] Документировать где проходит граница Presentation security vs Domain rules.

### 🟢 Could Have (Опционально)
- [ ] Добавить future note для object-level access.

### ⚫ Won't Have (Не будем делать)
- [ ] Не переносить `Portfolio` security classes или permissions.

## 4. Implementation Plan (План реализации)
1. [ ] Проверить inventory security findings.
2. [ ] Выбрать neutral example module.
3. [ ] Реализовать минимальные classes и tests.
4. [ ] Обновить docs/checklist.
5. [ ] Запустить `make check`.

## 5. Definition of Done (Критерии приёмки)
- [ ] Security pattern виден как example, не как обязательная production auth subsystem.
- [ ] Controllers не содержат business permission logic.
- [ ] Tests зелёные.
- [ ] `make check` проходит.

## 6. Verification (Самопроверка)
```bash
make check
```

## 7. Risks and Dependencies (Риски и зависимости)
- Риск добавить слишком сложный RBAC — ограничить route/action permission example.

## 8. Sources (Источники)
- [x] [Epic](EPIC-skeleton-module-ddd-scaffold.todo.md)
- [x] [User module task](done/TASK-skeleton-user-module-ddd-example.todo.md)


## 9. Comments (Комментарии)
Задача заведена как часть epic approval PR. Перед передачей исполнителю тимлид должен создать task subbranch от epic branch и заполнить `assignee`, `branch`, `status: in_progress`.

## Change History (История изменений)
| Дата | Автор (роль) | Изменение |
| :--- | :--- | :--- |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создание задачи в рамках эпика `EPIC-skeleton-module-ddd-scaffold` |
