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
assignee: Бэкендер Левша (codex-cli)
branch: task/skeleton-module-extension-points
pr: https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/12
status: in_progress
---

# TASK-skeleton-module-extension-points: Module resource extension points

## 0. Простое описание (Human Brief)
### Проблема простыми словами (Problem)
- Новым проектам нужен единый способ подключать module-local config, Doctrine mappings, Twig templates и translations.
- Без явных extension points проекты копируют настройки вручную и легко расходятся с conventions.

### Варианты или путь решения (Solution Sketch)
- Выполнить задачу как самостоятельный slice эпика `EPIC-skeleton-module-ddd-scaffold`.
- Следовать границам эпика: переносить только generic skeleton patterns, не бизнес-домен.

### Ожидаемый результат (Expected Result)
- Skeleton показывает canonical module-local paths и безопасную регистрацию ресурсов без Doctrine `auto_mapping: true`.

## 1. Concept and Goal (Концепция и Цель)
### Story (Job Story)
> Когда я создаю новый Symfony DDD/CQRS проект из skeleton, я хочу иметь этот slice как проверенный reference, чтобы не копировать решения из бизнесового проекта вручную.

### Goal (Цель по SMART)
Добавить или уточнить extension points для module-local `Resource/config`, Doctrine mappings/entities, Twig templates и translations в skeleton.

## 2. Context and Scope (Контекст и Границы)
*   **Где делаем:** `src/Component/ModuleSystem`, `config/`, `apps/web`, `docs/` — точные пути определить после inventory.
*   **Текущее поведение:** Skeleton содержит базовые modules, но module-local resource path pattern не оформлен как переносимый контракт.
*   **Границы (Out of Scope):** Не добавлять generator CLI и не включать глобальный Doctrine auto-mapping.

## 3. Requirements (Требования, MoSCoW)
### 🔴 Must Have (Обязательно)
- [ ] Описать/реализовать module-local resource path contract.
- [ ] Подключить Doctrine mappings явно per module, без `auto_mapping: true`.
- [ ] Показать Twig templates и translations paths для web modules.
- [ ] Покрыть extension behavior unit/integration tests или документированной проверкой, если код не меняется.

### 🟡 Should Have (Желательно)
- [ ] Добавить маленький checklist для нового module resource layout.

### 🟢 Could Have (Опционально)
- [ ] Оставить notes для будущего `make module NAME=... --dry-run`.

### ⚫ Won't Have (Не будем делать)
- [ ] Не переносить контейнеризацию или project-specific service config из `stocks2`.

## 4. Implementation Plan (План реализации)
1. [ ] Сверить skeleton conventions и inventory по module resource paths.
2. [ ] Внести минимальные extension points или docs contract.
3. [ ] Добавить tests/fixtures, если меняется код регистрации ресурсов.
4. [ ] Запустить `make check`.

## 5. Definition of Done (Критерии приёмки)
- [ ] Новый module может объявить config/mapping/templates/translations по документированному пути.
- [ ] Doctrine mapping registration явная и не ломает существующие modules.
- [ ] Docs описывают структуру `Resource/*`.
- [ ] `make check` проходит.

## 6. Verification (Самопроверка)
```bash
make check
```

## 7. Risks and Dependencies (Риски и зависимости)
- Риск сломать boot kernel или web container — проверять console/web integration tests.

## 8. Sources (Источники)
- [x] [Epic](EPIC-skeleton-module-ddd-scaffold.todo.md)
- [x] [Inventory task](done/TASK-skeleton-patterns-inventory.todo.md)
- [x] `../docs/conventions/index.md`


## 9. Comments (Комментарии)
Задача заведена как часть epic approval PR. Перед передачей исполнителю тимлид должен создать task subbranch от epic branch и заполнить `assignee`, `branch`, `status: in_progress`.

## Инструкции для сабагента

**Ветка:** `task/skeleton-module-extension-points` (уже создана и активна)
**PR:** draft из `task/skeleton-module-extension-points` в `epic/skeleton-module-ddd-scaffold` — [PR #12](https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/12).

### Порядок действий
1. Переключись в ветку `task/skeleton-module-extension-points`: `git checkout task/skeleton-module-extension-points`.
2. Реализуй задачу согласно описанию, epic boundaries и inventory.
3. Следуй [Конвенциям](../docs/conventions/index.md), `AGENTS.md` и [`todo/AGENTS.md`](AGENTS.md).
4. Делай промежуточные commits после логического этапа.
5. После реализации запусти `make check`.
6. Сделай `git push`.
7. Переведи PR из draft в ready: `gh pr ready <PR_NUMBER>`.
8. Не трогай untracked `phpstan.neon.dist`; не переноси `Portfolio`/`TInvest`/broker/trading vocabulary в runtime skeleton.

## Change History (История изменений)
| Дата | Автор (роль) | Изменение |
| :--- | :--- | :--- |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создание задачи в рамках эпика `EPIC-skeleton-module-ddd-scaffold` |
| 2026-06-02 | Лид Арагорн (codex-cli) | Задача запущена по `epic-via-subagents`, подготовлена task branch |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создан draft PR #12 для реализации |
