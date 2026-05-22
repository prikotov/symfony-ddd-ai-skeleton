# Guidelines: Web Application (`apps/web`)

Этот файл действует для изменений внутри `apps/web`. Корневой `AGENTS.md` остаётся главным источником общих правил.

## Назначение

`apps/web` — HTTP application: controllers, routes, templates, forms, UI components, Stimulus/Turbo/AssetMapper assets и app-specific tests.

Web слой не содержит business logic. Controller принимает HTTP request, валидирует/presents input, вызывает Application через bus и возвращает response/view.

## Структура

```text
apps/web/src/Module/{ModuleName}/
├── Controller/
│   └── {SubjectName}/
│       └── {ActionName}Controller.php
├── Resource/
│   ├── config/services.yaml
│   ├── templates/
│   └── translations/
├── Route/
│   └── {SubjectName}Route.php
└── {ModuleName}Module.php
```

## Controllers

- Controller должен быть `final readonly`, если возможно.
- Используй route classes для route name/path constants внутри module.
- Controller не должен содержать business logic, SQL, external API calls или сложную orchestration.
- Для use case вызывай `CommandBusComponentInterface` / `QueryBusComponentInterface`.
- Не добавляй fallback-и, которые маскируют ошибки данных или внешних API.

## Templates и UI

- Twig templates держи рядом с web-модулем в `Resource/templates`.
- Не смешивай presentation formatting с business calculations.
- Stimulus/Turbo/AssetMapper используй для UI-интерактивности без утяжеления backend controller.

## Tests

- App-specific web tests размещай в `apps/web/tests` с namespace `Skeleton\Web\Test\...`.
- Integration tests web-модулей размещай в `apps/web/tests/Integration/Module/<ModuleName>`.
- E2E/browser tests добавляй только после появления e2e-инфраструктуры.
