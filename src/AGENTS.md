# Guidelines: Common Code (`src`)

Этот файл действует для общего кода и shared modules в `src/`. Корневой `AGENTS.md` остаётся главным источником общих правил.

## Назначение

`src/` содержит общий kernel, reusable components, Application contracts, Infrastructure components и shared business modules.

## Слои модуля

```text
src/Module/{ModuleName}/
├── Domain/
├── Application/
├── Infrastructure/
├── Integration/
├── Resource/config/services.yaml
└── {ModuleName}Module.php
```

## Domain

- Не зависит от Application, Infrastructure, Integration, Presentation.
- Содержит business rules, entities, value objects, domain services и domain interfaces.
- VO именуй с постфиксом `Vo`, свойства private readonly, создание через constructor/factory по conventions.

## Application

- Содержит Commands, Queries, Handlers, DTO и тонкую orchestration.
- Не вызывает другие use case напрямую или через bus.
- Не зависит от Presentation.
- Исключения внешних зависимостей должны быть замаплены в project exceptions.

## Infrastructure

- Реализует technical details: persistence, filesystem, cache, framework adapters.
- Интерфейсы для Application/Domain держи в соответствующем внутреннем слое, реализации — здесь.

## Integration

- Внешние API, events, listeners, cross-module взаимодействие.
- Не содержит business logic.

## Tests

- Domain/Application покрывай unit tests.
- Infrastructure/module wiring покрывай integration tests.
- Tests не должны ходить в реальные внешние сервисы.
