---
type: docs
created: 2026-06-02
value: V4
complexity: C2
priority: P1
cost_plan:
cost_fact:
depends_on: TASK-skeleton-module-extension-points, TASK-skeleton-repository-criteria-pagination-sort, TASK-skeleton-health-query-example, TASK-skeleton-user-module-ddd-example, TASK-skeleton-presentation-security-pattern, TASK-skeleton-integration-bridge-example
epic: EPIC-skeleton-module-ddd-scaffold
author: Лид Арагорн (codex-cli)
assignee: Hermione (codex-cli)
branch: task/skeleton-module-scaffold-docs
pr: https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/18
status: review
---

# TASK-skeleton-module-scaffold-docs: Module scaffold documentation and checklist

## 0. Простое описание (Human Brief)
### Проблема простыми словами (Problem)
- Даже с кодовыми examples новым проектам нужен короткий маршрут: какие папки создать, какие слои использовать и что не тащить из домена.
- Без docs skeleton patterns останутся неявными и будут неправильно копироваться.

### Варианты или путь решения (Solution Sketch)
- Выполнить задачу как самостоятельный slice эпика `EPIC-skeleton-module-ddd-scaffold`.
- Следовать границам эпика: переносить только generic skeleton patterns, не бизнес-домен.

### Ожидаемый результат (Expected Result)
- Есть документация/checklist “как создать новый module” и раздел границ generic skeleton vs project-specific domain.

## 1. Concept and Goal (Концепция и Цель)
### Story (Job Story)
> Когда я создаю новый Symfony DDD/CQRS проект из skeleton, я хочу иметь этот slice как проверенный reference, чтобы не копировать решения из бизнесового проекта вручную.

### Goal (Цель по SMART)
Описать module scaffold patterns, flow Presentation → Application → Domain/Infrastructure → Integration, resource paths, security, repositories and boundaries.

## 2. Context and Scope (Контекст и Границы)
*   **Где делаем:** `docs/`, возможно `README.md`, links from epic/tasks.
*   **Текущее поведение:** Эпик описывает intent, но нет итогового user-facing guide по module scaffold.
*   **Границы (Out of Scope):** Не документировать Portfolio/TInvest migration, broker API или production deployment.

## 3. Requirements (Требования, MoSCoW)
### 🔴 Must Have (Обязательно)
- [x] Добавить checklist создания нового module.
- [x] Описать layer responsibilities and forbidden shortcuts.
- [x] Описать resource paths, repository criteria/pagination/sort, Presentation security, Integration bridge.
- [x] Явно объяснить `generic skeleton` vs `project-specific domain` boundaries.
- [x] Добавить links to Health/User examples.

### 🟡 Should Have (Желательно)
- [x] Добавить Mermaid flow diagram.

### 🟢 Could Have (Опционально)
- [x] Добавить backlog note на future generator.

### ⚫ Won't Have (Не будем делать)
- [x] Не писать domain migration guide for stocks/stocks2.

## 4. Implementation Plan (План реализации)
1. [x] Собрать outputs предыдущих задач.
2. [x] Написать concise guide and checklist.
3. [x] Добавить links from README/conventions where appropriate.
4. [x] Запустить docs and full checks.

## 5. Definition of Done (Критерии приёмки)
- [x] Docs помогают создать module без чтения `stocks2`.
- [x] Boundaries against Portfolio/TInvest are explicit.
- [x] Markdown links валидны.
- [x] `make check` проходит.

## 6. Verification (Самопроверка)
```bash
make check
```

## 7. Risks and Dependencies (Риски и зависимости)
- Риск воды в документации — держать checklist practical and short.

## 8. Sources (Источники)
- [x] [Epic](EPIC-skeleton-module-ddd-scaffold.todo.md)
- [x] `../docs/conventions/index.md`


## 9. Comments (Комментарии)
Задача заведена как часть epic approval PR. Перед передачей исполнителю тимлид должен создать task subbranch от epic branch и заполнить `assignee`, `branch`, `status: in_progress`.

## Инструкции для сабагента

**Ветка:** `task/skeleton-module-scaffold-docs` (уже создана и активна)
**PR:** draft из `task/skeleton-module-scaffold-docs` в `epic/skeleton-module-ddd-scaffold` — [PR #18](https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/18).

### Порядок действий
1. Переключись в ветку `task/skeleton-module-scaffold-docs`: `git checkout task/skeleton-module-scaffold-docs`.
2. Реализуй задачу согласно описанию и outputs всех завершённых tasks эпика.
3. Следуй [Конвенциям](../docs/conventions/index.md), `AGENTS.md` и [`todo/AGENTS.md`](AGENTS.md).
4. Напиши practical guide/checklist для создания нового module в skeleton.
5. Обязательно покрой: layer responsibilities, resource paths, module extension points, repository criteria/sort/pagination, Health Query example, User DDD example, Presentation security pattern, Integration bridge.
6. Явно отдели generic skeleton patterns от project-specific domain; запрети перенос `Portfolio`/`TInvest`/broker/trading examples.
7. Добавь links from README или existing docs, если это помогает найти guide.
8. Не редактируй generated `docs/conventions/` как source of truth.
9. После реализации запусти `make check`.
10. Сделай `git push`.
11. Переведи PR из draft в ready: `gh pr ready <PR_NUMBER>`.
12. Не трогай untracked `phpstan.neon.dist`.

## Change History (История изменений)
| Дата | Автор (роль) | Изменение |
| :--- | :--- | :--- |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создание задачи в рамках эпика `EPIC-skeleton-module-ddd-scaffold` |
| 2026-06-02 | Лид Арагорн (codex-cli) | Задача запущена по `epic-via-subagents`, подготовлена task branch |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создан draft PR #18 для реализации |
| 2026-06-02 | Техпис Гермиона (codex-cli) | Добавлен module scaffold guide, README-link, задача переведена в `review` |
