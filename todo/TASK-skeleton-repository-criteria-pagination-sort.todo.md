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
assignee:
branch:
pr:
status: todo
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
- [ ] Добавить generic pagination DTO/request mapper или equivalent primitive.
- [ ] Добавить sort mapper с whitelist allowed fields.
- [ ] Добавить criteria interfaces/value objects без business vocabulary.
- [ ] Покрыть edge cases: unknown sort field, default page/limit policy, stable ordering.

### 🟡 Should Have (Желательно)
- [ ] Документировать пример использования в repository implementation.

### 🟢 Could Have (Опционально)
- [ ] Добавить small fixture/demo repository для тестов.

### ⚫ Won't Have (Не будем делать)
- [ ] Не добавлять GraphQL/API Platform-specific pagination в этот slice.

## 4. Implementation Plan (План реализации)
1. [ ] Проверить inventory и существующие skeleton components.
2. [ ] Спроектировать минимальный набор classes/interfaces.
3. [ ] Реализовать primitives и tests.
4. [ ] Связать с Health/User examples только если это не утяжеляет slice.
5. [ ] Запустить `make check`.

## 5. Definition of Done (Критерии приёмки)
- [ ] Sort whitelist обязателен перед применением к Doctrine/query builder.
- [ ] Primitives имеют нейтральные names и строгую типизацию.
- [ ] Unit tests покрывают основные edge cases.
- [ ] `make check` проходит.

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

## Change History (История изменений)
| Дата | Автор (роль) | Изменение |
| :--- | :--- | :--- |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создание задачи в рамках эпика `EPIC-skeleton-module-ddd-scaffold` |
