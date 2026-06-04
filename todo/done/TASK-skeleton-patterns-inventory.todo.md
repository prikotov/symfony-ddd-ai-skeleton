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
status: done
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
- [x] Проверить module paths, Presentation security, Application use cases, Domain models/repositories/criteria, Infrastructure repositories, Integration bridges, pagination/sorting.
- [x] Разделить findings на `generic skeleton pattern`, `example-only`, `project-specific / do not move`.
- [x] Явно отметить запрет на перенос `Portfolio`, `TInvest`, broker/trading vocabulary в runtime skeleton.
- [x] Сформировать рекомендации для последующих задач эпика.

### 🟡 Should Have (Желательно)
- [x] Добавить короткий vocabulary risk checklist для ревью последующих задач.

### 🟢 Could Have (Опционально)
- [x] Предложить backlog-идею generator после стабилизации templates.

### ⚫ Won't Have (Не будем делать)
- [x] Не реализовывать перенос кода в этой задаче.

## 4. Implementation Plan (План реализации)
1. [x] Прочитать текущие module conventions skeleton и relevant slices `stocks2`.
2. [x] Собрать таблицу или секцию findings `take / adapt / reject`.
3. [x] Сверить findings с MoSCoW эпика и обновить комментарии/документацию, если нужно.
4. [x] Запустить todo/docs validation для изменённых markdown-файлов.

## 5. Definition of Done (Критерии приёмки)
- [x] Inventory оформлен в задаче, эпике или отдельном docs-файле.
- [x] Каждая последующая задача имеет подтверждённый source pattern или explicit no-copy boundary.
- [x] `Portfolio`/`TInvest` отмечены как prohibited runtime scope.
- [x] Markdown/todo validation проходит.

## 6. Verification (Самопроверка)
```bash
composer todo:validate
composer docs:validate
```

## 7. Risks and Dependencies (Риски и зависимости)
- Риск принять бизнесовый naming за generic pattern — снижать через отдельную колонку `do not move`.

## 8. Sources (Источники)
- [x] [Epic](EPIC-skeleton-module-ddd-scaffold.todo.md)
- [x] `../../AGENTS.md`
- [x] `/home/dp/MyProjects/stocks2`


## 9. Comments (Комментарии)
Задача заведена как часть epic approval PR. Перед передачей исполнителю тимлид должен создать task subbranch от epic branch и заполнить `assignee`, `branch`, `status: done`.

---

## 10. Inventory Reusable Patterns из `stocks2`

> **Источник:** `/home/dp/MyProjects/stocks2` — полный анализ кодовой базы.
> **Текущий skeleton:** `/home/dp/MyProjects/symfony-ddd-ai-skeleton`.

### Легенда классификации

| Метка | Значение |
| :--- | :--- |
| ✅ **TAKE** | Переносим как generic skeleton pattern (framework-level) |
| 🔧 **ADAPT / example-only** | Переносим структуру/подход как нейтральный пример, но не переносим бизнес-значения и concrete domain implementation |
| ❌ **REJECT** | Не переносим — project-specific domain, оставляем в `stocks2` |

---

### 10.1. Module System (`src/Component/ModuleSystem`)

| Паттерн | Файл в `stocks2` | Вердикт | Примечание |
| :--- | :--- | :--- | :--- |
| `ModuleInterface` | `Component/ModuleSystem/ModuleInterface.php` | ✅ **TAKE** | Уже перенесён в skeleton. Определяет `getModuleDir()`, `getModuleConfigPath()`. Полностью generic. |
| `ModuleCompilerPass` | `Component/ModuleSystem/DependencyInjection/ModuleCompilerPass.php` | ✅ **TAKE** | Уже перенесён. Загружает `services.yaml`, `services.php`, `services_{env}.php` из `Resource/config`. |
| `DoctrineInterface` | `Component/ModuleSystem/Extension/DoctrineInterface.php` | ✅ **TAKE** | Расширение `ModuleInterface` для Doctrine: `getMappingPath()`, `getEntityNamespace()`. Generic. **В skeleton отсутствует — нужна задача `TASK-skeleton-module-extension-points`.** |
| `TwigInterface` | `Component/ModuleSystem/Extension/TwigInterface.php` | ✅ **TAKE** | Расширение для Twig: `getBaseTemplatesPath()`, `getBaseTwigNamespace()`, `getAdditionalTemplatesPaths()`. Generic. **В skeleton отсутствует — нужна задача `TASK-skeleton-module-extension-points`.** |
| `TwigCompilerPass` | `Component/ModuleSystem/DependencyInjection/TwigCompilerPass.php` | ✅ **TAKE** | Compiler pass для регистрации Twig paths из модулей. Проверка дубликатов namespace/path. **В skeleton отсутствует — нужна задача `TASK-skeleton-module-extension-points`.** |

**Рекомендация:** Задача `TASK-skeleton-module-extension-points` — добавить `DoctrineInterface`, `TwigInterface`, `TwigCompilerPass`.

---

### 10.2. Repository Criteria / Pagination / Sorting (`src/Component/Repository`)

| Паттерн | Файл в `stocks2` | Вердикт | Примечание |
| :--- | :--- | :--- | :--- |
| `SortableCriteriaInterface` | `Component/Repository/SortableCriteriaInterface.php` | ✅ **TAKE** | `setSort(array $order)`, `getSort(): array` с `SortEnum`. Полностью generic. **В skeleton отсутствует.** |
| `CriteriaWithLimitInterface` | `Component/Repository/CriteriaWithLimitInterface.php` | ✅ **TAKE** | `setLimit(int)`, `getLimit(): ?int`. **В skeleton отсутствует.** |
| `CriteriaWithOffsetInterface` | `Component/Repository/CriteriaWithOffsetInterface.php` | ✅ **TAKE** | `setOffset(int)`, `getOffset(): ?int`. **В skeleton отсутствует.** |
| `SortableCriteriaTrait` | `Component/Repository/Trait/SortableCriteriaTrait.php` | ✅ **TAKE** | Реализация `SortableCriteriaInterface`. **В skeleton отсутствует.** |
| `CriteriaWithLimitTrait` | `Component/Repository/Trait/CriteriaWithLimitTrait.php` | ✅ **TAKE** | Реализация `CriteriaWithLimitInterface`. **В skeleton отсутствует.** |
| `CriteriaWithOffsetTrait` | `Component/Repository/Trait/CriteriaWithOffsetTrait.php` | ✅ **TAKE** | Реализация `CriteriaWithOffsetInterface`. **В skeleton отсутствует.** |
| `SortEnum` | `Component/Repository/Enum/SortEnum.php` | ✅ **TAKE** | `asc = 'ASC'`, `desc = 'DESC'`. Generic. **В skeleton отсутствует.** |
| `LimitOffsetSortCriteriaMapper` | `Component/Repository/Criteria/Mapper/LimitOffsetSortCriteriaMapper.php` | ✅ **TAKE** | Маппер criteria → `Doctrine\Common\Collections\Criteria` с limit/offset/sort. Generic. **В skeleton отсутствует.** |
| `PaginationDto` | `Application/Dto/PaginationDto.php` | ✅ **TAKE** | Уже перенесён в skeleton. `$limit`, `$offset = 0`. |

**Критический observation:** В `stocks2` **нет whitelist allowed sort fields**. Sort fields приходят напрямую в criteria без валидации. Эпик требует добавить whitelist. Это **новый паттерн**, которого нет в `stocks2` — его нужно спроектировать с нуля.

**Рекомендация:** Задача `TASK-skeleton-repository-criteria-pagination-sort` — перенести все interfaces/traits/enum/mapper + добавить **новый** `AllowedSortFieldsTrait` или аналогичный механизм whitelist.

---

### 10.3. Domain Model / Repository / Criteria Pattern

#### Паттерн: Entity с ORM-маппингом

| Паттерн | Источник | Вердикт | Примечание |
| :--- | :--- | :--- | :--- |
| `UserModel` (Entity) | `Module/User/Domain/Entity/User/UserModel.php` | 🔧 **ADAPT** | Структура entity правильная: constructor promotion, ORM attributes, `#[SensitiveParameter]`, `isActive()` метод. **Адаптация:** скопировать структуру, но переименовать под skeleton namespace. `UserStatusEnum` — нейтральный. |
| `UserStatusEnum` | `Module/User/Domain/Enum/UserStatusEnum.php` | 🔧 **ADAPT** | Только `active = 10`. Нейтральный. Можно использовать как example. |
| `TiInstrumentModel`, `TiPortfolioModel`, `TiPosition*`, `TiLastPriceModel` | `Module/TInvest/Domain/Entity/` | ❌ **REJECT** | Бизнес-сущности брокерского API и market data. Запрещены в skeleton. |

#### Паттерн: Repository Interface

| Паттерн | Источник | Вердикт | Примечание |
| :--- | :--- | :--- | :--- |
| `UserReadRepositoryInterface` | `Module/User/Domain/Repository/User/UserReadRepositoryInterface.php` | 🔧 **ADAPT** | Канонический contract: `getById()`, `getOneByCriteria()`, `getByCriteria()`, `getCountByCriteria()`. Generic pattern. **Адаптация:** namespace под skeleton, добавить в User example module. |
| `UserCriteriaInterface` | `Module/User/Domain/Repository/User/UserCriteriaInterface.php` | 🔧 **ADAPT** | Пустой marker interface для type-safety criteria. Generic pattern. |
| `UserFindCriteria` | `Module/User/Domain/Repository/User/Criteria/UserFindCriteria.php` | 🔧 **ADAPT** | Пример criteria с валидацией в constructor. Нейтральный (`username`, `status`). |
| `TiPortfolio*Criteria*` | `Module/TInvest/Domain/Repository/Ti*/Criteria/*` | ❌ **REJECT** | Брокерский домен. Но **pattern** (criteria implements marker + SortableCriteriaInterface + uses trait) — generic. |

**Рекомендация:** Задача `TASK-skeleton-user-module-ddd-example` — перенести User domain pattern (entity, enum, criteria, repository interface) как нейтральный example.

---

### 10.4. Infrastructure Repository Pattern

| Паттерн | Источник | Вердикт | Примечание |
| :--- | :--- | :--- | :--- |
| `UserReadRepository` | `Module/User/Infrastructure/Repository/User/UserReadRepository.php` | 🔧 **ADAPT** | Канонический Infrastructure repository: extends `ServiceEntityRepository`, делегирует criteria mapping в `CriteriaMapper`, оборачивает ORM exceptions в `InfrastructureException`. Структура полностью generic. **Адаптация:** namespace под skeleton. |
| Infrastructure `CriteriaMapper` | `Module/User/Infrastructure/Repository/User/Criteria/CriteriaMapper.php` | 🔧 **ADAPT** | Dispatcher pattern: `match($criteria::class)` → конкретный mapper. Generic. **Адаптация:** namespace под skeleton. |
| `UserFindCriteriaMapper` | `Module/User/Infrastructure/Repository/User/Criteria/Mapper/UserFindCriteriaMapper.php` | 🔧 **ADAPT** | Конкретный criteria → QueryBuilder mapper. Структура generic, содержание нейтральное (`username`, `status`). |
| `TiPortfolioReadRepository` + criteria mappers | `Module/TInvest/Infrastructure/Repository/TiPortfolio/` | ❌ **REJECT** | Брокерский домен. Но **pattern** идентичен User — можно опираться на User при переносе. |

**Ключевой observation:** `TiPortfolioFindCriteriaMapper` демонстрирует использование `LimitOffsetSortCriteriaMapper` — это единственный пример в `stocks2`, где criteria с sort/limit/offset маппится в Doctrine. Этот **approach** (инъекция `LimitOffsetSortCriteriaMapper` в конкретный criteria mapper) нужно воспроизвести в skeleton example.

**Рекомендация:** Задача `TASK-skeleton-repository-criteria-pagination-sort` — перенести `LimitOffsetSortCriteriaMapper` и показать его использование в Infrastructure criteria mapper.

---

### 10.5. Application Use Case Pattern

| Паттерн | Источник | Вердикт | Примечание |
| :--- | :--- | :--- | :--- |
| `QueryInterface` | `Application/Query/QueryInterface.php` | ✅ **TAKE** | Уже в skeleton. `@template TResult`. |
| `CommandInterface` | `Application/Command/CommandInterface.php` | ✅ **TAKE** | Уже в skeleton. `@template TResult`. |
| `QueryBusComponentInterface` | `Application/Component/QueryBus/QueryBusComponentInterface.php` | ✅ **TAKE** | Уже в skeleton. |
| `CommandBusComponentInterface` | `Application/Component/CommandBus/CommandBusComponentInterface.php` | ✅ **TAKE** | Уже в skeleton. |
| `GetRuntimeDiagnosticsQuery` + Handler | `Module/Diagnostics/Application/UseCase/Query/GetRuntimeDiagnostics/` | ✅ **TAKE** | Уже в skeleton (common Diagnostics). Канонический read-only query example. |
| `GetActiveUserQuery` + Handler | `Module/User/Application/UseCase/Query/GetActiveUser/` | 🔧 **ADAPT** | Pattern: `#[AsMessageHandler]` readonly handler, query implements `QueryInterface`, возвращает result DTO. Нейтральный. **Адаптация:** namespace под skeleton, добавить в User example module. |
| `GetActiveUserResultDto` | `Module/User/Application/UseCase/Query/GetActiveUser/GetActiveUserResultDto.php` | 🔧 **ADAPT** | Пример result DTO. |
| `GetPositionListQuery` + Handler | `Module/Portfolio/Application/UseCase/Query/GetPositionList/` | ❌ **REJECT** | Слишком сложный (aggregation, reason codes, freshness, valuation coverage). Бизнес-домен portfolio. **Pattern** (query → handler → result DTO) generic, но implementation — нет. |
| `DatabaseDiagnosticsDtoMapper` | `Module/Diagnostics/Application/Mapper/DatabaseDiagnosticsDtoMapper.php` | ✅ **TAKE** | Pattern: VO → DTO mapper. Уже частично в skeleton. |
| `DomainPortfolioAggregatesDtoToPortfolioAggregatesDtoMapper` | `Module/Portfolio/Application/Mapper/` | ❌ **REJECT** | Бизнес-домен. |

**Рекомендация:** Задача `TASK-skeleton-user-module-ddd-example` — добавить `GetActiveUserQuery`/`Handler`/`ResultDto` как Application layer example. Задача `TASK-skeleton-health-query-example` — убедиться, что Diagnostics остаётся минимальным.

---

### 10.6. Presentation Security Pattern (`apps/web/src/Module/Portfolio/Security/`)

| Паттерн | Источник | Вердикт | Примечание |
| :--- | :--- | :--- | :--- |
| `ActionEnum` | `Security/Portfolio/ActionEnum.php` | 🔧 **ADAPT** | Enum действий: `case view = 'portfolio.portfolio.view'`. **Pattern** generic, но значения — portfolio domain. **Адаптация:** создать нейтральный example (например `user.view`, `user.list`). |
| `PermissionEnum` | `Security/Portfolio/PermissionEnum.php` | 🔧 **ADAPT** | Enum разрешений: `case viewAll = 'portfolio.portfolio.viewAll'`. **Pattern** generic. **Адаптация:** нейтральные значения. |
| `Grant` | `Security/Portfolio/Grant.php` | ✅ **TAKE** | Проверка `isGranted(ActionEnum::*->value)` через `AuthorizationCheckerInterface`. Структура generic; в skeleton сохраняем имя `Grant` по Presentation conventions. |
| `Rule` | `Security/Portfolio/Rule.php` | ✅ **TAKE** | Проверка permissions через `RoleHierarchyInterface`. Структура generic. |
| `Voter` | `Security/Portfolio/Voter.php` | ✅ **TAKE** | `supports()` проверяет `ActionEnum::tryFrom()` + subject null. `voteOnAttribute()` делегирует в `Rule`. Структура generic. |
| `RoleEnum` | `apps/web/src/Module/User/Security/User/RoleEnum.php` | 🔧 **ADAPT** | Web/Presentation-specific enum; `case portfolioViewer = 'ROLE_PORTFOLIO_VIEWER'`. **Pattern** generic, значение — portfolio. **Адаптация:** нейтральные роли. |

**Ключевой observation:** Вся цепочка `ActionEnum → PermissionEnum → RoleEnum → Rule → Voter → Grant` — это **generic pattern**. Бизнес-значения (portfolio, viewer) заменяются на нейтральные. Сама структура wiring — reusable.

**Рекомендация:** Задача `TASK-skeleton-presentation-security-pattern` — создать нейтральный security example (User module) с полной цепочкой `ActionEnum → PermissionEnum → RoleEnum → Rule → Voter → Grant`.

---

### 10.7. Presentation Route / Controller Pattern

| Паттерн | Источник | Вердикт | Примечание |
| :--- | :--- | :--- | :--- |
| `HealthRoute` | `apps/web/Module/Diagnostics/Route/HealthRoute.php` | ✅ **TAKE** | Уже в skeleton. Constants + `RouterInterface` для генерации URL. |
| `CheckController` | `apps/web/Module/Diagnostics/Controller/Health/CheckController.php` | ✅ **TAKE** | Уже в skeleton. Attributes: `#[Route]`, `#[AsController]`. QueryBus → JsonResponse. |
| `PortfolioRoute` | `apps/web/Module/Portfolio/Route/PortfolioRoute.php` | ❌ **REJECT** | Бизнес-домен. Но **pattern** (constants для name/path + RouterInterface) generic. |
| `PositionListController` | `apps/web/Module/Portfolio/Controller/Position/PositionListController.php` | ❌ **REJECT** | Бизнес-домен. Но **pattern** (`#[Route]` + `#[AsController]` + `#[IsGranted]` + QueryBus + Twig render) — generic. |
| `UserRoute` | `apps/web/Module/User/Route/UserRoute.php` | 🔧 **ADAPT** | Constants + RouterInterface + HTTP methods. Нейтральный. |
| `LoginController` / `LogoutController` | `apps/web/Module/User/Controller/Auth/` | 🔧 **ADAPT** | Auth flow controllers. **Адаптация:** только если User example включает auth pattern; без production credentials. |
| `LoginFormModel` / `LoginFormType` | `apps/web/Module/User/Form/Auth/` | 🔧 **ADAPT** | Symfony form pattern. Нейтральный. |

**Рекомендация:** Задача `TASK-skeleton-presentation-security-pattern` — создать Route + Controller с `#[IsGranted]` в нейтральном User/Demo context.

---

### 10.8. Integration Bridge Pattern

| Паттерн | Источник | Вердикт | Примечание |
| :--- | :--- | :--- | :--- |
| `GetPositionSnapshotServiceInterface` | `Module/Portfolio/Domain/Service/PositionSnapshot/GetPositionSnapshotServiceInterface.php` | 🔧 **ADAPT** | **Pattern:** consumer-owned interface в Domain слоя модуля-потребителя. Interface объявляет контракт, `Integration` реализует его через QueryBus другого модуля. Структура generic. **Адаптация:** нейтральный example без broker vocabulary. |
| `GetPositionSnapshotService` (Integration) | `Module/Portfolio/Integration/Service/TInvest/GetPositionSnapshotService.php` | 🔧 **ADAPT** | **Pattern:** Integration service реализует Domain interface, вызывает Application Query другого модуля через `QueryBusComponentInterface`. Структура generic. **Адаптация:** нейтральный example. |
| DTO-маппинг в Integration | `Integration/Service/TInvest/GetPositionSnapshotService.php` (mapper methods) | 🔧 **ADAPT** | **Pattern:** Integration слой маппит DTO другого модуля в DTO своего модуля. Generic approach. |

> Пояснение: для `GetPositionSnapshotService` классификация двойная намеренно. **ADAPT/example-only** относится к структуре bridge (consumer-owned interface → Integration service → QueryBus другого module), а **REJECT** — к конкретному файлу с T-Invest/Portfolio vocabulary.

**Ключевой observation:** Вся Integration bridge строится на принципе:
1. Consumer module объявляет interface в `Domain/Service/{Context}/`
2. Consumer module реализует в `Integration/Service/`
3. Реализация дергает `QueryBusComponentInterface` другого модуля
4. Между DTO модулей нет shared dependency — маппинг в Integration слое

**Рекомендация:** Задача `TASK-skeleton-integration-bridge-example` — создать нейтральный example: ModuleA потребляет данные ModuleB через consumer-owned interface + Integration bridge.

---

### 10.9. Module Registration Pattern

| Паттерн | Источник | Вердикт | Примечание |
| :--- | :--- | :--- | :--- |
| `DiagnosticsModule` (common) | `src/Module/Diagnostics/DiagnosticsModule.php` | ✅ **TAKE** | Уже в skeleton. `implements ModuleInterface`. |
| `DiagnosticsModule` (web) | `apps/web/src/Module/Diagnostics/DiagnosticsModule.php` | ✅ **TAKE** | Уже в skeleton. |
| `UserModule` (common) | `src/Module/User/UserModule.php` | 🔧 **ADAPT** | `implements ModuleInterface, DoctrineInterface`. Показывает как module регистрирует Doctrine mappings. **Адаптация:** namespace под skeleton. |
| `PortfolioModule` / `TInvestModule` | `src/Module/{Portfolio,TInvest}/*Module.php` | ❌ **REJECT** | Бизнес-домен. |
| `config/modules.php` | `config/modules.php` | ✅ **TAKE** | Уже в skeleton. Регистрация common модулей. |
| `apps/web/config/modules.php` | `apps/web/config/modules.php` | ✅ **TAKE** | Уже в skeleton. Регистрация app-level модулей. |

---

### 10.10. Event System (`src/Component/Event`)

| Паттерн | Источник | Вердикт | Примечание |
| :--- | :--- | :--- | :--- |
| `EventInterface` | `Component/Event/EventInterface.php` | ✅ **TAKE** | Уже в skeleton. `getEventUuid()`, `getOccurredOn()`. |
| `EventBusInterface` | `Component/Event/EventBusInterface.php` | ✅ **TAKE** | Уже в skeleton. `dispatch(EventInterface)`. |

**Примечание:** Event system уже перенесён и не требует действий в рамках эпика.

---

### 10.11. Diagnostics Module (stocks2 vs skeleton)

| Компонент | В `stocks2` | В skeleton | Вердикт |
| :--- | :--- | :--- | :--- |
| `RuntimeDiagnosticsDto` | ✅ | ✅ (упрощённый) | ✅ **TAKE** |
| `DatabaseDiagnosticsDto` / `DatabaseTableDiagnosticsDto` | ✅ | ❌ | 🔧 **ADAPT** — рассмотреть в `TASK-skeleton-health-query-example`, если DB diagnostics нужен как example |
| `DatabaseDiagnosticsVo` / `DatabaseTableDiagnosticsVo` | ✅ | ❌ | 🔧 **ADAPT** |
| `GetDatabaseDiagnosticsServiceInterface` | ✅ | ❌ | 🔧 **ADAPT** |
| `GetDatabaseDiagnosticsService` (Infrastructure) | ✅ | ❌ | 🔧 **ADAPT** |
| `DatabaseDiagnosticsDtoMapper` | ✅ | ❌ | 🔧 **ADAPT** |
| `RuntimeContextVo` | ✅ | ✅ | ✅ **TAKE** |
| `GetRuntimeContextServiceInterface` | ✅ | ✅ | ✅ **TAKE** |
| `GetRuntimeContextService` | ✅ | ✅ | ✅ **TAKE** |

**Рекомендация:** Задача `TASK-skeleton-health-query-example` — убедиться что Diagnostics остаётся минимальным read-only query. DB diagnostics — optional enhancement, не блокер.

---

## 11. Summary: Classification Matrix

### ✅ TAKE — Generic skeleton patterns (переносим как есть или уже перенесены)

| # | Pattern | Source в `stocks2` | Target задача эпика |
| :--- | :--- | :--- | :--- |
| 1 | `ModuleInterface` | `Component/ModuleSystem/` | Уже в skeleton |
| 2 | `ModuleCompilerPass` | `Component/ModuleSystem/DependencyInjection/` | Уже в skeleton |
| 3 | `DoctrineInterface` | `Component/ModuleSystem/Extension/` | `TASK-skeleton-module-extension-points` |
| 4 | `TwigInterface` | `Component/ModuleSystem/Extension/` | `TASK-skeleton-module-extension-points` |
| 5 | `TwigCompilerPass` | `Component/ModuleSystem/DependencyInjection/` | `TASK-skeleton-module-extension-points` |
| 6 | `SortableCriteriaInterface` | `Component/Repository/` | `TASK-skeleton-repository-criteria-pagination-sort` |
| 7 | `CriteriaWithLimitInterface` | `Component/Repository/` | `TASK-skeleton-repository-criteria-pagination-sort` |
| 8 | `CriteriaWithOffsetInterface` | `Component/Repository/` | `TASK-skeleton-repository-criteria-pagination-sort` |
| 9 | `SortableCriteriaTrait` | `Component/Repository/Trait/` | `TASK-skeleton-repository-criteria-pagination-sort` |
| 10 | `CriteriaWithLimitTrait` | `Component/Repository/Trait/` | `TASK-skeleton-repository-criteria-pagination-sort` |
| 11 | `CriteriaWithOffsetTrait` | `Component/Repository/Trait/` | `TASK-skeleton-repository-criteria-pagination-sort` |
| 12 | `SortEnum` | `Component/Repository/Enum/` | `TASK-skeleton-repository-criteria-pagination-sort` |
| 13 | `LimitOffsetSortCriteriaMapper` | `Component/Repository/Criteria/Mapper/` | `TASK-skeleton-repository-criteria-pagination-sort` |
| 14 | `PaginationDto` | `Application/Dto/` | Уже в skeleton |
| 15 | `QueryInterface` / `CommandInterface` / `*BusComponentInterface` | `Application/` | Уже в skeleton |
| 16 | `EventInterface` / `EventBusInterface` | `Component/Event/` | Уже в skeleton |
| 17 | Security `Grant` / `Rule` / `Voter` (структура) | `apps/web/Module/Portfolio/Security/Portfolio/` | `TASK-skeleton-presentation-security-pattern` |

### 🔧 ADAPT — Переносим структуру/подход с нейтральной номенклатурой

| # | Pattern | Source в `stocks2` | Адаптация | Target задача эпика |
| :--- | :--- | :--- | :--- | :--- |
| 1 | `UserModel` Entity | `Module/User/Domain/Entity/User/UserModel.php` | Namespace → skeleton | `TASK-skeleton-user-module-ddd-example` |
| 2 | `UserStatusEnum` | `Module/User/Domain/Enum/UserStatusEnum.php` | Namespace → skeleton | `TASK-skeleton-user-module-ddd-example` |
| 3 | `UserReadRepositoryInterface` | `Module/User/Domain/Repository/User/` | Namespace → skeleton | `TASK-skeleton-user-module-ddd-example` |
| 4 | `UserCriteriaInterface` + `UserFindCriteria` | `Module/User/Domain/Repository/User/` | Namespace → skeleton | `TASK-skeleton-user-module-ddd-example` |
| 5 | `UserReadRepository` (Infrastructure) | `Module/User/Infrastructure/Repository/User/` | Namespace → skeleton | `TASK-skeleton-user-module-ddd-example` |
| 6 | Infrastructure `CriteriaMapper` dispatcher | `Module/User/Infrastructure/Repository/User/Criteria/` | Namespace → skeleton | `TASK-skeleton-user-module-ddd-example` |
| 7 | `GetActiveUserQuery` + Handler + ResultDto | `Module/User/Application/UseCase/Query/GetActiveUser/` | Namespace → skeleton | `TASK-skeleton-user-module-ddd-example` |
| 8 | `ActionEnum` / `PermissionEnum` | `Security/Portfolio/ActionEnum.php`, `PermissionEnum.php` | Нейтральные значения вместо `portfolio.*` | `TASK-skeleton-presentation-security-pattern` |
| 9 | `RoleEnum` | `apps/web/src/Module/User/Security/User/RoleEnum.php` | Нейтральные web/presentation роли вместо `ROLE_PORTFOLIO_VIEWER` | `TASK-skeleton-presentation-security-pattern` |
| 10 | Consumer-owned Integration interface | `Portfolio/Domain/Service/PositionSnapshot/GetPositionSnapshotServiceInterface.php` | Нейтральный пример | `TASK-skeleton-integration-bridge-example` |
| 11 | Integration bridge service | `Portfolio/Integration/Service/TInvest/GetPositionSnapshotService.php` | Нейтральный пример без TInvest | `TASK-skeleton-integration-bridge-example` |
| 12 | `UserModule` (с DoctrineInterface) | `src/Module/User/UserModule.php` | Namespace → skeleton | `TASK-skeleton-module-extension-points` |
| 13 | DB Diagnostics (Dto, Vo, Service, Mapper) | `Module/Diagnostics/Application|Domain|Infrastructure/` | Опционально, если нужен richer example | `TASK-skeleton-health-query-example` |
| 14 | `UserRoute` + `LoginController`/`LogoutController` | `apps/web/Module/User/` | Нейтральный route/auth pattern | `TASK-skeleton-presentation-security-pattern` |
| 15 | `LoginFormModel` / `LoginFormType` | `apps/web/Module/User/Form/Auth/` | Нейтральный form pattern | `TASK-skeleton-presentation-security-pattern` |

### ❌ REJECT — Project-specific, остаётся в `stocks2`

| # | Pattern | Причина запрета |
| :--- | :--- | :--- |
| 1 | `Portfolio` module (все слои) | Инвестиционный домен: позиции, агрегаты, валюта, freshness, valuation coverage, position detail/snapshot DTOs |
| 2 | `TInvest` module (все слои) | Брокерский API-домен: T-Invest API entities, repositories, mappers |
| 3 | `TiInstrument*`, `TiPortfolio*`, `TiPosition*` entities | Брокерские модели инструментов, портфелей, позиций |
| 4 | `TiPortfolio*Repository`, `TiPortfolioCurrency*Repository`, `TiPosition*Repository` | Брокерские read models |
| 5 | `GetPositionSnapshotService` (Integration, конкретная реализация) | Интеграция с T-Invest Application layer; **reject concrete file**, while bridge structure remains ADAPT/example-only |
| 6 | `GetPositionListQueryHandler`, `GetPositionDetailQuery/Handler/ResultDto` | Слишком сложный для skeleton: aggregation, reason codes, freshness, valuation coverage и detail flow — всё portfolio-specific |
| 7 | `PositionRowMapper`, `PortfolioPositionDtoToAggregatePositionDtoMapper`, `PositionSnapshotDto` и subclasses, `CurrencyBucketDto`, `PortfolioAggregatePositionDto` | Portfolio DTO mapping and snapshot/aggregate logic |
| 8 | `PortfolioAggregatesCalculator` | Portfolio-specific domain calculation |
| 9 | `AccountKindEnum`, `FreshnessEnum`, `PositionTypeEnum`, `ValuationCoverageEnum`, `AggregatePositionTypeEnum` | Portfolio/TInvest enums |
| 10 | `PositionAmbiguityException`, `PositionNotFoundException` | Portfolio exceptions |
| 11 | `PortfolioRoute`, `PositionListController`, `PositionDetailController` | Portfolio Presentation (routes, controllers, templates) |
| 12 | `PortfolioModule` (web app) | Portfolio-specific web module registration |

---

## 12. Prohibited Vocabulary в Runtime Skeleton

> 🚫 **Эти термины НЕ должны появляться в runtime коде skeleton (src/, apps/).**

| Запрещённый термин | Почему |
| :--- | :--- |
| `Portfolio` | Инвестиционный домен |
| `TInvest`, `T-Invest`, `TiPortfolio`, `TiPosition`, `TiInstrument` | Брокерский API |
| `Broker`, `BrokerClient` | Брокерская интеграция |
| `Position` (в контексте портфеля) | Инвестиционный домен |
| `Security` (в контексте ценной бумаги) | Инвестиционный домен |
| `Figi`, `Ticker`, `Isin`, `Instrument` | Биржевая номенклатура |
| `MarketData`, `LastPrice` | Рыночные данные |
| `AccountKind` (investment/margin) | Инвестиционный домен |
| `Valuation`, `Freshness`, `Actionability` (portfolio metrics) | Portfolio metrics |
| `Port` / `Adapter` (в путях/именах) | Запрещено конвенцией |

> `Security` как Symfony component или имя Presentation security layer разрешён. Запрещён только `Security` как финансовый термин «ценная бумага» / investment instrument.

---

## 13. Vocabulary Risk Checklist

> ✋ **Для каждой последующей задачи эпика, перед переносом кода, проверь:**

- [ ] В переносимом коде нет `Portfolio`, `TInvest`, `Ti` prefix?
- [ ] Нет broker/trading/market-data терминов?
- [ ] Нет `Port`/`Adapter` в путях и именах классов?
- [ ] Entity/Enum/Criteria не содержат инвестиционной номенклатуры (figi, ticker, isin, instrument, position, security)?
- [ ] Controller/Route не содержат `/portfolio`, `/position`, `/account` путей?
- [ ] Voter/Grant/Rule/Permission не ссылаются на portfolio viewer/manager роли?
- [ ] Integration bridge не ссылается на конкретный внешний API (T-Invest, broker)?
- [ ] Нет предположений о shared DB ownership или specific schema?

---


## 13.1. Architectural Note: module without Infrastructure

`stocks2` показывает важный pattern: модуль может не иметь собственного `Infrastructure` layer, если он не владеет persistence и работает как aggregation/coordination module. Например, `Portfolio` получает данные через Integration bridge из `TInvest`, а repositories живут в `TInvest`/`User`. Для skeleton docs это важно сформулировать как правило: Infrastructure появляется только при владении технической реализацией (DB/filesystem/external client), а не автоматически в каждом module.

## 14. Sort Whitelist Gap

`stocks2` **не имеет** механизма whitelist allowed sort fields. Criteria принимают произвольные sort fields, которые напрямую передаются в Doctrine. Эпик требует добавить whitelist перед Doctrine criteria.

**Предложение для `TASK-skeleton-repository-criteria-pagination-sort`:**

- Добавить `AllowedSortFieldsTrait` или валидацию в `LimitOffsetSortCriteriaMapper::map()`:
  - Принять `array $allowedFields` (whitelist field names).
  - При вызове `setSort()` или в mapper — выбрасывать `InvalidArgumentException` если sort field не в whitelist.
- Это **новый паттерн**, не существующий в `stocks2`.

---

## 15. Recommendations per Epic Task

| Задача эпика | Source patterns | Действие |
| :--- | :--- | :--- |
| `TASK-skeleton-module-extension-points` | `DoctrineInterface`, `TwigInterface`, `TwigCompilerPass` из `stocks2` + `UserModule` как example | Перенести interfaces и compiler pass. Показать пример module с `DoctrineInterface`. |
| `TASK-skeleton-repository-criteria-pagination-sort` | Все `Component/Repository/*` + `LimitOffsetSortCriteriaMapper` + pattern из `TiPortfolioFindCriteriaMapper` | Перенести generic components. Добавить **новый** sort whitelist. Показать usage example. |
| `TASK-skeleton-health-query-example` | Текущий skeleton Diagnostics (уже перенесён) | Убедиться что minimal и read-only. Опционально добавить DB diagnostics. |
| `TASK-skeleton-user-module-ddd-example` | `Module/User` Domain + Application + Infrastructure | Перенести с нейтральным namespace: entity, enum, criteria, repository interface, infrastructure repository, query handler. |
| `TASK-skeleton-presentation-security-pattern` | Security chain из `Portfolio/Security/` + `UserRoute` | Создать нейтральный example: `ActionEnum → PermissionEnum → RoleEnum → Rule → Voter → Grant` + Route + Controller с `#[IsGranted]`. |
| `TASK-skeleton-integration-bridge-example` | `Portfolio/Domain/Service/PositionSnapshot/GetPositionSnapshotServiceInterface` + `Portfolio/Integration/Service/TInvest/GetPositionSnapshotService` | Создать нейтральный example: ModuleA consumer-owned interface + ModuleB bridge через QueryBus. |
| `TASK-skeleton-module-scaffold-docs` | Все findings из этого inventory | Описать checklist создания нового module + границы generic vs domain-specific. |

---


## 15.1. Authorization vs Authentication Scope Note

Для `TASK-skeleton-presentation-security-pattern` Must Have должен быть именно Authorization pattern: `ActionEnum → PermissionEnum → RoleEnum → Rule → Voter → Grant`. Authentication flow (`LoginController`, `LogoutController`, `LoginFormModel`, `LoginFormType`, firewall/session/templates) — отдельный concern; в текущем эпике его стоит держать как Could Have или вынести в отдельную future task, чтобы не расширять scope security slice.

## 16. Backlog Idea: Module Generator

После стабилизации всех templates из эпика, можно завести backlog-задачу на CLI generator:

- `make module NAME=Foo`
- Генерирует directory structure, `FooModule.php`, `Resource/config/services.yaml`, пустые Domain/Application/Infrastructure/Integration layers.
- `--dry-run` для preview.
- No-overwrite если файлы уже существуют.
- Не реализовывать в рамках текущего эпика.

## Инструкции для сабагента

**Ветка:** `task/skeleton-patterns-inventory` (уже создана и активна)
**PR:** draft из `task/skeleton-patterns-inventory` в `epic/skeleton-module-ddd-scaffold` — [PR #11](https://github.com/prikotov/symfony-ddd-ai-skeleton/pull/11).

### Порядок действий
1. Переключись в ветку `task/skeleton-patterns-inventory`.
2. Выполни задачу согласно описанию и границам эпика.
3. Следуй [Конвенциям](../../docs/conventions/index.md) и [`todo/AGENTS.md`](../AGENTS.md).
4. Не переноси `Portfolio`/`TInvest`/broker/trading vocabulary в runtime skeleton.
5. Для docs-only изменений запусти `composer todo:validate` и `composer docs:validate`; если меняешь код/config — запусти `make check`.
6. Не делай commit/push — тимлид проверит и выполнит git-операции.

## Change History (История изменений)
| Дата | Автор (роль) | Изменение |
| :--- | :--- | :--- |
| 2026-06-02 | Лид Арагорн (codex-cli) | Создание задачи в рамках эпика `EPIC-skeleton-module-ddd-scaffold` |
| 2026-06-02 | Лид Арагорн (codex-cli) | Задача запущена по `epic-via-subagents`, создан draft PR #11 |
| 2026-06-02 | Аналитик Шерлок (codex-cli) | Выполнен полный inventory patterns из `stocks2`; классификация take/adapt/reject, prohibited vocabulary, vocabulary risk checklist, sort whitelist gap analysis, рекомендации по задачам эпика |
| 2026-06-02 | Лид Арагорн (codex-cli) | Уточнены minor observations self-review: example-only label, RoleEnum path, explicit Portfolio/TInvest rejects, Integration bridge note |
| 2026-06-02 | Архитектор Локи (codex-cli) | Review approval; зафиксированы non-blocking observations: Security term, module without Infrastructure, auth vs authorization scope |
| 2026-06-02 | Лид Арагорн (codex-cli) | Задача переведена в done после self-review и external review approval |
