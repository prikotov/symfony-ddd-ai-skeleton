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
assignee: Бэкендер Левша (codex-cli)
branch: task/skeleton-integration-bridge-example
pr: https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/17
status: done
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
- [x] Consumer module owns integration interface in Domain service namespace.
- [x] Implementation lives in Integration layer and calls other module Application query/DTO.
- [x] Нет прямой зависимости на Domain model другого module.
- [x] Не используются names `Port`/`Adapter`.
- [x] Tests показывают bridge behavior через fake/application double.

### 🟡 Should Have (Желательно)
- [x] Добавить диаграмму или docs snippet с dependency direction.

### 🟢 Could Have (Опционально)
- [x] Использовать Diagnostics/User examples as neutral modules.

### ⚫ Won't Have (Не будем делать)
- [ ] Не переносить MOEX/T-Invest integration examples.

## 4. Implementation Plan (План реализации)
1. [x] Выбрать два нейтральных modules для example.
2. [x] Описать consumer-owned contract.
3. [x] Реализовать Integration service and tests.
4. [x] Обновить docs.
5. [x] Запустить `make check`.

## 5. Definition of Done (Критерии приёмки)
- [x] Example соблюдает layer/module isolation.
- [x] Contract naming не содержит Port/Adapter.
- [x] Tests зелёные.
- [x] `make check` проходит.

## 6. Verification (Самопроверка)
```bash
make check
```

## 7. Risks and Dependencies (Риски и зависимости)
- Риск циклических dependencies — проверять deptrac.

## 8. Sources (Источники)
- [x] [Epic](EPIC-skeleton-module-ddd-scaffold.todo.md)
- [x] [User module task](TASK-skeleton-user-module-ddd-example.todo.md)


## 9. Comments (Комментарии)
Задача заведена как часть epic approval PR. Перед передачей исполнителю тимлид должен создать task subbranch от epic branch и заполнить `assignee`, `branch`, `status: in_progress`.

## Инструкции для сабагента

**Ветка:** `task/skeleton-integration-bridge-example` (уже создана и активна)
**PR:** draft из `task/skeleton-integration-bridge-example` в `epic/skeleton-module-ddd-scaffold` — [PR #17](https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/17).

### Порядок действий
1. Переключись в ветку `task/skeleton-integration-bridge-example`: `git checkout task/skeleton-integration-bridge-example`.
2. Реализуй задачу согласно описанию, epic boundaries и User/Diagnostics examples.
3. Следуй [Конвенциям](../../docs/conventions/index.md), `AGENTS.md` и [`todo/AGENTS.md`](../AGENTS.md).
4. Покажи consumer-owned integration interface в `Domain/Service/Integration`, implementation — в `Integration/Service`.
5. Implementation должна вызывать Application query/DTO другого module, а не его Domain model/repository/infrastructure.
6. Не используй термины `Port`/`Adapter` в class/path names.
7. Не добавляй external API clients, broker integrations, shared DB writes, migrations, secrets.
8. Tests должны ловить dependency direction и bridge behavior через fake/application double.
9. После реализации запусти `make check`.
10. Сделай `git push`.
11. Переведи PR из draft в ready: `gh pr ready <PR_NUMBER>`.
12. Не трогай untracked `phpstan.neon.dist`; не переноси `Portfolio`/`TInvest`/broker/trading vocabulary.

## Change History (История изменений)
| Дата | Автор (роль) | Изменение |
| :--- | :--- | :--- |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создание задачи в рамках эпика `EPIC-skeleton-module-ddd-scaffold` |
| 2026-06-02 | Лид Арагорн (codex-cli) | Задача запущена по `epic-via-subagents`, подготовлена task branch |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создан draft PR #17 для реализации |
| 2026-06-02 | Бэкендер Левша (codex-cli) | Реализован User → Diagnostics integration bridge, статус переведён в `review` |
| 2026-06-02 | Лид Арагорн (codex-cli) | Закрыто неблокирующее замечание external review: добавлен negative test на unexpected QueryBus result |
| 2026-06-02 | Бэкендер Левша (codex-cli) | Финальный self-review после commit `ba1f914`: Approval |
| 2026-06-02 | Архитектор Локи (codex-cli) | Финальный external re-check PR #17: Approval |
| 2026-06-02 | Архитектор Гэндальф (codex-cli) | External architecture review PR #17: Approval |
| 2026-06-02 | Лид Арагорн (codex-cli) | Задача переведена в `done`, подготовлена к merge в epic branch |
