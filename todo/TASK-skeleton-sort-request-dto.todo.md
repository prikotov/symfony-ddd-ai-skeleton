---
type: feat
created: 2026-06-10
value: V2
complexity: C1
priority: P1
cost_plan:
cost_fact:
depends_on:
epic:
author: Лид Арагорн (codex-cli)
assignee: Лид Арагорн (codex-cli)
branch: task/add-sort-request-dto
pr:
status: in_progress
---

# TASK-skeleton-sort-request-dto: Sort request DTO for web lists

## 0. Простое описание (Human Brief)
### Проблема простыми словами (Problem)
- В skeleton уже есть pagination request DTO для web-списков, но нет парного sort request DTO.
- Из-за этого при переносе list-сценариев из проектов на базе skeleton приходится вручную добавлять transport-модель для параметра `sort`.

### Варианты или путь решения (Solution Sketch)
- Перенести минимальный reusable `SortRequestDto` из рабочего проекта в `apps/web/src/Component/Sort`.
- Адаптировать `namespace` под skeleton и не переносить зависимости, которых нет в skeleton.
- Добавить unit-тест на transport-validation.

### Ожидаемый результат (Expected Result)
- В web-приложении skeleton есть готовый DTO для query-параметра `sort`, совместимый с текущими conventions.

## 1. Concept and Goal (Концепция и Цель)
### Story (Job Story)
> Когда я добавляю sortable list в web-приложение на базе skeleton, я хочу использовать готовый `SortRequestDto`, чтобы не копировать один и тот же transport contract вручную.

### Goal (Цель по SMART)
Добавить cross-cutting presentation DTO для query-параметра `sort` и покрыть его unit-тестом в рамках одного PR.

## 2. Context and Scope (Контекст и Границы)
*   **Где делаем:** `apps/web/src/Component/Sort`, `apps/web/tests/Unit/Component/Sort`.
*   **Текущее поведение:** `PaginationRequestDto` есть, `SortRequestDto` отсутствует.
*   **Границы (Out of Scope):** Не добавлять OpenAPI/Nelmio зависимости, sort mapper, изменения контроллеров или бизнес-логику.

## 3. Requirements (Требования, MoSCoW)
### 🔴 Must Have (Обязательно)
- [x] Добавить `SortRequestDto` в `Skeleton\Web\Component\Sort`.
- [x] Сохранить nullable `sort` и `NotBlank(allowNull: true)` validation metadata.
- [x] Покрыть DTO unit-тестом.

### 🟡 Should Have (Желательно)
- [x] Не переносить OpenAPI attributes без зависимости в skeleton.

### 🟢 Could Have (Опционально)
- [ ] Добавить mapper в Application sort DTO отдельной задачей.

### ⚫ Won't Have (Не будем делать)
- [x] Не менять существующие controllers.
- [x] Не добавлять новые Composer dependencies.

## 4. Implementation Plan (План реализации)
1. [x] Проверить текущее состояние repository и наличие sort components.
2. [x] Сверить DTO с presentation/query DTO conventions.
3. [x] Добавить `SortRequestDto` с skeleton namespace.
4. [x] Добавить unit-тест для null, blank и обычного значения.
5. [x] Запустить `make check`.

## 5. Definition of Done (Критерии приёмки)
- [x] DTO добавлен в web component namespace.
- [x] Новый код покрыт unit-тестом.
- [x] `make check` проходит успешно.

## 6. Verification (Самопроверка)
```bash
make check
```

## 7. Risks and Dependencies (Риски и зависимости)
- OpenAPI attributes из исходного проекта не переносились, потому что skeleton не содержит соответствующей зависимости.
- Mapper для преобразования sort в application-level DTO намеренно вынесен за рамки этой задачи.

## 8. Sources (Источники)
- Исходный файл: `/home/dp/MyProjects/TasK/Development/apps/web/src/Component/Sort/SortRequestDto.php`

## 9. Comments (Комментарии)
- Задача оформлена при подготовке PR согласно project workflow.

## Change History (История изменений)
| Дата | Автор (роль) | Изменение |
| :--- | :--- | :--- |
| 2026-06-10 | Лид Арагорн (codex-cli) | Создание задачи и фиксация scope для PR |
