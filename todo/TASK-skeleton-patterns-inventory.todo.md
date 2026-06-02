---
type: docs
created: 2026-06-02
value: V4
complexity: C2
priority: P1
cost_plan:
cost_fact:
depends_on: 
epic: EPIC-skeleton-module-ddd-scaffold
author: Лид Арагорн (codex-cli)
assignee: Аналитик Шерлок (codex-cli)
branch: task/skeleton-patterns-inventory
pr: https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/11
status: in_progress
---

# TASK-skeleton-patterns-inventory: Inventory reusable module patterns from stocks2

## 0. Простое описание (Human Brief)
### Проблема простыми словами (Problem)
- Часть полезных module patterns уже есть в `stocks2`, но неясно, что из этого generic, а что является бизнес-доменом.
- Без inventory легко случайно перенести `Portfolio`/`TInvest` vocabulary или слишком тяжёлые project-specific решения в skeleton.

### Варианты или путь решения (Solution Sketch)
- Выполнить задачу как самостоятельный slice эпика `EPIC-skeleton-module-ddd-scaffold`.
- Следовать границам эпика: переносить только generic skeleton patterns, не бизнес-домен.

### Ожидаемый результат (Expected Result)
- Есть проверенный список `берём / не берём`, который задаёт границы всего эпика.

## 1. Concept and Goal (Концепция и Цель)
### Story (Job Story)
> Когда я создаю новый Symfony DDD/CQRS проект из skeleton, я хочу иметь этот slice как проверенный reference, чтобы не копировать решения из бизнесового проекта вручную.

### Goal (Цель по SMART)
Подготовить inventory reusable patterns из `stocks2` с классификацией generic skeleton pattern vs project-specific domain и рекомендациями по задачам эпика.

## 2. Context and Scope (Контекст и Границы)
*   **Где делаем:** `/home/dp/MyProjects/stocks2`, текущий skeleton, `todo/` и `docs/` при необходимости.
*   **Текущее поведение:** В эпике есть предварительный scope, но нет отдельного проверенного inventory-артефакта.
*   **Границы (Out of Scope):** Не переносить код, не менять runtime skeleton, не создавать интеграции с broker API.

## 3. Requirements (Требования, MoSCoW)
### 🔴 Must Have (Обязательно)
- [ ] Проверить module paths, Presentation security, Application use cases, Domain models/repositories/criteria, Infrastructure repositories, Integration bridges, pagination/sorting.
- [ ] Разделить findings на `generic skeleton pattern`, `example-only`, `project-specific / do not move`.
- [ ] Явно отметить запрет на перенос `Portfolio`, `TInvest`, broker/trading vocabulary в runtime skeleton.
- [ ] Сформировать рекомендации для последующих задач эпика.

### 🟡 Should Have (Желательно)
- [ ] Добавить короткий vocabulary risk checklist для ревью последующих задач.

### 🟢 Could Have (Опционально)
- [ ] Предложить backlog-идею generator после стабилизации templates.

### ⚫ Won't Have (Не будем делать)
- [ ] Не реализовывать перенос кода в этой задаче.

## 4. Implementation Plan (План реализации)
1. [ ] Прочитать текущие module conventions skeleton и relevant slices `stocks2`.
2. [ ] Собрать таблицу или секцию findings `take / adapt / reject`.
3. [ ] Сверить findings с MoSCoW эпика и обновить комментарии/документацию, если нужно.
4. [ ] Запустить todo/docs validation для изменённых markdown-файлов.

## 5. Definition of Done (Критерии приёмки)
- [ ] Inventory оформлен в задаче, эпике или отдельном docs-файле.
- [ ] Каждая последующая задача имеет подтверждённый source pattern или explicit no-copy boundary.
- [ ] `Portfolio`/`TInvest` отмечены как prohibited runtime scope.
- [ ] Markdown/todo validation проходит.

## 6. Verification (Самопроверка)
```bash
composer todo:validate
composer docs:validate
```

## 7. Risks and Dependencies (Риски и зависимости)
- Риск принять бизнесовый naming за generic pattern — снижать через отдельную колонку `do not move`.

## 8. Sources (Источники)
- [x] [Epic](EPIC-skeleton-module-ddd-scaffold.todo.md)
- [x] `../AGENTS.md`
- [x] `/home/dp/MyProjects/stocks2`


## 9. Comments (Комментарии)
Задача заведена как часть epic approval PR. Перед передачей исполнителю тимлид должен создать task subbranch от epic branch и заполнить `assignee`, `branch`, `status: in_progress`.

## Инструкции для сабагента

**Ветка:** `task/skeleton-patterns-inventory` (уже создана и активна)
**PR:** draft из `task/skeleton-patterns-inventory` в `epic/skeleton-module-ddd-scaffold` — [PR #11](https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/11).

### Порядок действий
1. Переключись в ветку `task/skeleton-patterns-inventory`.
2. Выполни задачу согласно описанию и границам эпика.
3. Следуй [Конвенциям](../docs/conventions/index.md) и [`todo/AGENTS.md`](AGENTS.md).
4. Не переноси `Portfolio`/`TInvest`/broker/trading vocabulary в runtime skeleton.
5. Для docs-only изменений запусти `composer todo:validate` и `composer docs:validate`; если меняешь код/config — запусти `make check`.
6. Не делай commit/push — тимлид проверит и выполнит git-операции.

## Change History (История изменений)
| Дата | Автор (роль) | Изменение |
| :--- | :--- | :--- |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создание задачи в рамках эпика `EPIC-skeleton-module-ddd-scaffold` |
| 2026-06-02 | Лид Арагорн (codex-cli) | Задача запущена по `epic-via-subagents`, создан draft PR #11 |
