# Guidelines: Tests

## Размещение и namespace

- Common unit tests: `tests/Unit`, namespace `Skeleton\Common\Test\Unit\...`.
- Common integration tests: `tests/Integration`, namespace `Skeleton\Common\Test\Integration\...`.
- Web app tests: `apps/web/tests`, namespace `Skeleton\Web\Test\...`.
- Console app tests: `apps/console/tests`, namespace `Skeleton\Console\Test\...`.

## Уровни

### Unit

Проверяют business logic без Symfony kernel, DB и внешних сервисов. Внешние зависимости заменяй fake/mock/stub.

### Integration

Проверяют взаимодействие слоёв, Symfony kernel/container, infrastructure adapters и app entrypoints. Если нужен kernel, используй `KernelTestCase` и `self::bootKernel()`.

### E2E

Добавляй только после появления e2e-инфраструктуры конкретного проекта.

## Стиль

- AAA: Arrange → Act → Assert.
- Имена тестов: `test{WhatIsBeingTested}{Scenario}{ExpectedResult}`.
- Не используй реальные external services, secrets или production DB.
