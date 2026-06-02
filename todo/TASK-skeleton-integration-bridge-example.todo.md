---
type: feat
created: 2026-06-02
value: V3
complexity: C3
priority: P2
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

# TASK-skeleton-integration-bridge-example: Consumer-owned integration bridge example

## 0. Простое описание (Human Brief)
### Проблема простыми словами (Problem)
- Межмодульное взаимодействие часто превращается в прямую связку доменных моделей разных модулей.
- Skeleton должен показать безопасный bridge через consumer-owned integration interface без терминов `Port`/`Adapter`.

### Варианты или путь решения (Solution Sketch)
- Выполнить задачу как самостоятельный slice эпика `EPIC-skeleton-module-ddd-scaffold`.
- Следовать границам эпика: переносить только generic skeleton patterns, не бизнес-домен.

### Ожидаемый результат (Expected Result)
- Есть маленький example, где один module зависит от своего `Domain\Service\Integration\*Interface`, а реализация в `Integration` вызывает Application use case другого module.

## 1. Concept and Goal (Концепция и Цель)
### Story (Job Story)
> Когда я создаю новый Symfony DDD/CQRS проект из skeleton, я хочу иметь этот slice как проверенный reference, чтобы не копировать решения из бизнесового проекта вручную.

### Goal (Цель по SMART)
Добавить нейтральный Integration bridge example и docs для межмодульного взаимодействия.

## 2. Context and Scope (Контекст и Границы)
*   **Где делаем:** `src/Module/*/Domain/Service/Integration`, `src/Module/*/Integration/Service`, tests/docs.
*   **Текущее поведение:** Правило описано в conventions, но skeleton не даёт короткого runnable/reference example.
*   **Границы (Out of Scope):** Не добавлять external API clients, broker integrations или shared DB writes.

## 3. Requirements (Требования, MoSCoW)
### 🔴 Must Have (Обязательно)
- [ ] Consumer module owns integration interface in Domain service namespace.
- [ ] Implementation lives in Integration layer and calls other module Application query/DTO.
- [ ] Нет прямой зависимости на Domain model другого module.
- [ ] Не используются names `Port`/`Adapter`.
- [ ] Tests показывают bridge behavior через fake/application double.

### 🟡 Should Have (Желательно)
- [ ] Добавить диаграмму или docs snippet с dependency direction.

### 🟢 Could Have (Опционально)
- [ ] Использовать Diagnostics/User examples as neutral modules.

### ⚫ Won't Have (Не будем делать)
- [ ] Не переносить MOEX/T-Invest integration examples.

## 4. Implementation Plan (План реализации)
1. [ ] Выбрать два нейтральных modules для example.
2. [ ] Описать consumer-owned contract.
3. [ ] Реализовать Integration service and tests.
4. [ ] Обновить docs.
5. [ ] Запустить `make check`.

## 5. Definition of Done (Критерии приёмки)
- [ ] Example соблюдает layer/module isolation.
- [ ] Contract naming не содержит Port/Adapter.
- [ ] Tests зелёные.
- [ ] `make check` проходит.

## 6. Verification (Самопроверка)
```bash
make check
```

## 7. Risks and Dependencies (Риски и зависимости)
- Риск циклических dependencies — проверять deptrac.

## 8. Sources (Источники)
- [x] [Epic](EPIC-skeleton-module-ddd-scaffold.todo.md)
- [x] [User module task](done/TASK-skeleton-user-module-ddd-example.todo.md)


## 9. Comments (Комментарии)
Задача заведена как часть epic approval PR. Перед передачей исполнителю тимлид должен создать task subbranch от epic branch и заполнить `assignee`, `branch`, `status: in_progress`.

## Change History (История изменений)
| Дата | Автор (роль) | Изменение |
| :--- | :--- | :--- |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создание задачи в рамках эпика `EPIC-skeleton-module-ddd-scaffold` |
