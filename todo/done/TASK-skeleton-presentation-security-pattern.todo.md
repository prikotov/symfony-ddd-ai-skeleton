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
assignee: Фронтендер Амели (codex-cli)
branch: task/skeleton-presentation-security-pattern
pr: https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/16
status: done
---

# TASK-skeleton-presentation-security-pattern: Presentation security pattern example

## 0. Простое описание (Human Brief)
### Проблема простыми словами (Problem)
- В проектах повторяется pattern Route/Role/Action/Permission/Access/Rule/Voter, но в skeleton нет нейтрального reference.
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
Добавить neutral Presentation security pattern на примере User/demo module: route constants/generator, action, permission, access/rule/voter.

## 2. Context and Scope (Контекст и Границы)
*   **Где делаем:** `apps/web/src/Module/User` или demo module, security tests/docs.
*   **Текущее поведение:** Pattern был замечен в `stocks2`, но skeleton не должен копировать portfolio-specific names.
*   **Границы (Out of Scope):** Object-level ACL и сложный RBAC оставить future slice; не добавлять production roles.

## 3. Requirements (Требования, MoSCoW)
### 🔴 Must Have (Обязательно)
- [x] Route constants/generator pattern нейтрален и documented.
- [x] Action/Permission enums не используют investment vocabulary.
- [x] Access/Rule/Voter отделены от controller logic.
- [x] Tests покрывают allow/deny behavior на минимальном сценарии.

### 🟡 Should Have (Желательно)
- [x] Документировать где проходит граница Presentation security vs Domain rules.

### 🟢 Could Have (Опционально)
- [x] Добавить future note для object-level access.

### ⚫ Won't Have (Не будем делать)
- [ ] Не переносить `Portfolio` security classes или permissions.

## 4. Implementation Plan (План реализации)
1. [x] Проверить inventory security findings.
2. [x] Выбрать neutral example module.
3. [x] Реализовать минимальные classes и tests.
4. [x] Обновить docs/checklist.
5. [x] Запустить `make check`.

## 5. Definition of Done (Критерии приёмки)
- [x] Security pattern виден как example, не как обязательная production auth subsystem.
- [x] Controllers не содержат business permission logic.
- [x] Tests зелёные.
- [x] `make check` проходит.

## 6. Verification (Самопроверка)
```bash
make check
```

## 7. Risks and Dependencies (Риски и зависимости)
- Риск добавить слишком сложный RBAC — ограничить route/action permission example.

## 8. Sources (Источники)
- [x] [Epic](EPIC-skeleton-module-ddd-scaffold.todo.md)
- [x] [User module task](TASK-skeleton-user-module-ddd-example.todo.md)


## 9. Comments (Комментарии)
Задача заведена как часть epic approval PR. Перед передачей исполнителю тимлид должен создать task subbranch от epic branch и заполнить `assignee`, `branch`, `status: in_progress`.

## Инструкции для сабагента

**Ветка:** `task/skeleton-presentation-security-pattern` (уже создана и активна)
**PR:** draft из `task/skeleton-presentation-security-pattern` в `epic/skeleton-module-ddd-scaffold` — [PR #16](https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/16).

### Порядок действий
1. Переключись в ветку `task/skeleton-presentation-security-pattern`: `git checkout task/skeleton-presentation-security-pattern`.
2. Реализуй задачу согласно описанию, epic boundaries и User module example.
3. Следуй [Конвенциям](../../docs/conventions/index.md), `AGENTS.md` и [`todo/AGENTS.md`](../AGENTS.md).
4. Добавь маленький neutral web Presentation security pattern, а не production RBAC/auth subsystem.
5. Обязательные классы/понятия: route constants/generator, action/permission enum, access/rule/voter или минимальные equivalents.
6. Не добавляй login/registration/password/default roles/users, object-level ACL, real security firewall changes, secrets или external services.
7. Controllers/entrypoints не должны содержать permission decision logic; decision logic должна быть вынесена в rule/voter layer.
8. Tests должны покрывать allow/deny behavior без реального auth subsystem.
9. После реализации запусти `make check`.
10. Сделай `git push`.
11. Переведи PR из draft в ready: `gh pr ready <PR_NUMBER>`.
12. Не трогай untracked `phpstan.neon.dist`; не переноси `Portfolio`/`TInvest`/broker/trading vocabulary.

## Change History (История изменений)
| Дата | Автор (роль) | Изменение |
| :--- | :--- | :--- |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создание задачи в рамках эпика `EPIC-skeleton-module-ddd-scaffold` |
| 2026-06-02 | Лид Арагорн (codex-cli) | Задача запущена по `epic-via-subagents`, подготовлена task branch |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создан draft PR #16 для реализации |
| 2026-06-02 | Фронтендер Амели (codex-cli) | Реализован neutral Presentation security pattern, задача переведена в review |
| 2026-06-02 | Лид Арагорн (codex-cli) | Закрыт self-review CR: синхронизирован checklist `make check` после успешной проверки |
| 2026-06-02 | Лид Арагорн (codex-cli) | Закрыто неблокирующее замечание external review: добавлен regression test на `ListController` `#[IsGranted]` action |
| 2026-06-02 | Фронтендер Амели (codex-cli) | Финальный self-review после commit `7c387da`: Approval |
| 2026-06-02 | Архитектор Локи (codex-cli) | Финальный external re-check PR #16: Approval |
| 2026-06-02 | Архитектор Гэндальф (codex-cli) | External architecture review PR #16: Approval |
| 2026-06-02 | Лид Арагорн (codex-cli) | Задача переведена в `done`, подготовлена к merge в epic branch |
