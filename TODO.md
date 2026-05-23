# Roadmap

Planned improvements for the skeleton. Contributions welcome!

## Module tooling

- [ ] Scaffold commands: `make module`, common/web/console module generators
- [ ] Generator for: query + handler + test, command + handler + test, controller + route + test, console command + test
- [ ] Validate that every registered module has `Resource/config/services.yaml`

## DX

- [ ] Test kernel helper to reduce boilerplate in integration tests
- [ ] `make bootstrap` target wrapping `bin/bootstrap`
- [ ] Decide whether to keep `composer.lock` in skeleton or generate on bootstrap

## AI workflow

- [ ] Example smoke-test task in `todo/` for agent workflow validation
- [ ] Checklist for AI-generated PRs
- [ ] Skeleton-level AGENTS.md trimmed; domain safety overrides in a template file

## Documentation

- [ ] `docs/skeleton/quick-start.md`
- [ ] `docs/skeleton/module-creation.md`
- [ ] `docs/skeleton/testing.md`
- [ ] Request flow diagram

## Production readiness (project-level)

These are outside the skeleton scope but should be documented as next steps:

- [ ] Secrets policy and `.env.local` rules
- [ ] Real database configuration
- [ ] Observability and logging conventions
- [ ] Deploy and release workflow
