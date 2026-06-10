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
pr: https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/20
status: review
---

# TASK-skeleton-sort-request-dto: Sort request DTO for web lists

## 0. Простое описание (Human Brief)
### Проблема простыми словами (Problem)
- В skeleton уже есть pagination request DTO и mapper для web-списков, но нет парного sort request DTO и mapper.
- Из-за этого при переносе list-сценариев из проектов на базе skeleton приходится вручную добавлять transport-модель и преобразование параметра `sort`.

### Варианты или путь решения (Solution Sketch)
- Перенести минимальный reusable `SortRequestDto` и `SortRequestToApplicationDtoMapper` из рабочего проекта в `apps/web/src/Component/Sort`.
- Адаптировать `namespace` под skeleton и не переносить зависимости, которых нет в skeleton.
- Добавить общий Application `SortDto`, `SortDirectionEnum` и mapper в repository order.
- Подключить sort и pagination mapping в demo list controller, чтобы primitives были показаны в реальном сценарии.
- Добавить unit-тесты на transport-validation, mapping и controller usage.

### Ожидаемый результат (Expected Result)
- В web-приложении skeleton есть готовый DTO и mapper для query-параметра `sort`, совместимые с текущими conventions.

## 1. Concept and Goal (Концепция и Цель)
### Story (Job Story)
> Когда я добавляю sortable paginated list в web-приложение на базе skeleton, я хочу использовать готовые pagination/sort request DTO и mappers, чтобы не копировать один и тот же transport contract и mapping вручную.

### Goal (Цель по SMART)
Добавить cross-cutting presentation DTO/mapper для query-параметра `sort`, подключить его вместе с pagination mapper в demo list controller и покрыть unit-тестами в рамках одного PR.

## 2. Context and Scope (Контекст и Границы)
*   **Где делаем:** `apps/web/src/Component/Sort`, `apps/web/src/Module/User/Controller/UserProfile`, `src/Application`, `apps/web/tests/Unit/Component/Sort`, `tests/Unit/Application`.
*   **Текущее поведение:** `PaginationRequestDto`/mapper есть, `SortRequestDto`/mapper отсутствуют.
*   **Границы (Out of Scope):** Не добавлять OpenAPI/Nelmio зависимости, UI-sort controls или бизнес-логику.

## 3. Requirements (Требования, MoSCoW)
### 🔴 Must Have (Обязательно)
- [x] Добавить `SortRequestDto` в `Skeleton\Web\Component\Sort`.
- [x] Добавить `SortRequestToApplicationDtoMapper` с mandatory allowed sorts whitelist.
- [x] Добавить общий `SortDto` и `SortDirectionEnum` для Application boundary.
- [x] Добавить mapper из Application sort DTO в repository order.
- [x] Подключить sort mapper в `UserProfile` demo `ListController`.
- [x] Подключить pagination mapper в `UserProfile` demo `ListController`.
- [x] Сохранить nullable `sort` и `NotBlank(allowNull: true)` validation metadata.
- [x] Покрыть DTO и mappers unit-тестами.

### 🟡 Should Have (Желательно)
- [x] Не переносить OpenAPI attributes без зависимости в skeleton.

### 🟢 Could Have (Опционально)
- [ ] Добавить sort UI controls в Twig template отдельной задачей.

### ⚫ Won't Have (Не будем делать)
- [x] Не менять существующие controllers.
- [x] Не добавлять новые Composer dependencies.

## 4. Implementation Plan (План реализации)
1. [x] Проверить текущее состояние repository и наличие sort components.
2. [x] Сверить DTO с presentation/query DTO conventions.
3. [x] Добавить `SortRequestDto` с skeleton namespace.
4. [x] Добавить Application `SortDto`/`SortDirectionEnum`.
5. [x] Добавить mappers и unit-тесты для null/default/asc/desc/invalid/whitelist cases.
6. [x] Подключить sort и pagination mappers в `UserProfile` demo `ListController` и обновить controller test.
7. [x] Запустить `make check`.

## 5. Definition of Done (Критерии приёмки)
- [x] DTO и mapper добавлены в web component namespace.
- [x] Application sort DTO и direction enum добавлены без business vocabulary.
- [x] Demo controller использует pagination и sort request mappers при построении query.
- [x] Новый код покрыт unit-тестами.
- [x] `make check` проходит успешно.

## 6. Verification (Самопроверка)
```bash
make check
```

## 7. Risks and Dependencies (Риски и зависимости)
- OpenAPI attributes из исходного проекта не переносились, потому что skeleton не содержит соответствующей зависимости.
- UI-sort controls не добавлялись, чтобы не раздувать PR изменениями Twig-разметки.

## 8. Sources (Источники)
- Исходный файл: `/home/dp/MyProjects/TasK/Development/apps/web/src/Component/Sort/SortRequestDto.php`
- Исходный mapper: `/home/dp/MyProjects/TasK/Development/apps/web/src/Component/Sort/SortRequestToApplicationDtoMapper.php`
- Исходные Application primitives: `/home/dp/MyProjects/TasK/Development/src/Application/Dto/SortDto.php`, `/home/dp/MyProjects/TasK/Development/src/Application/Enum/SortDirectionEnum.php`, `/home/dp/MyProjects/TasK/Development/src/Application/Mapper/SortDtoToOrderMapper.php`

## 9. Comments (Комментарии)
- Задача оформлена при подготовке PR согласно project workflow.

## Change History (История изменений)
| Дата | Автор (роль) | Изменение |
| :--- | :--- | :--- |
| 2026-06-10 | Лид Арагорн (codex-cli) | Создание задачи и фиксация scope для PR |
| 2026-06-10 | Лид Арагорн (codex-cli) | Создан draft PR #20, задача переведена в review |
| 2026-06-10 | Лид Арагорн (codex-cli) | Добавлен sort mapper и связанные Application primitives по уточнению scope |
| 2026-06-10 | Лид Арагорн (codex-cli) | Sort mapper подключен в demo `UserProfile` list controller |
| 2026-06-10 | Лид Арагорн (codex-cli) | Pagination mapper подключен в demo `UserProfile` list controller |
