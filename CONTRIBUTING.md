# Contributing to Symfony DDD AI Skeleton

Thank you for your interest in contributing! This project is a reusable skeleton, so changes here affect every project built on top of it.

## Before you start

- Read [`AGENTS.md`](AGENTS.md) for project rules and architecture summary.
- Read [`docs/conventions/`](docs/conventions/) for coding standards and layer conventions.
- Keep changes focused: one PR — one logical task.

## Development setup

```bash
composer install
make check
```

All checks must pass before a PR is merged.

## Making changes

### Branch naming

- `task/<short-description>` — features, improvements
- `fix/<short-description>` — bug fixes
- `docs/<short-description>` — documentation only

### Code style

- PHP 8.4, strict types everywhere.
- PSR-12 + Slevomat rules (enforced by `phpcs`).
- DDD/CQRS layers enforced by Deptrac.

### Tests

- Every PHP/config change must include relevant tests.
- Unit tests: `tests/Unit/` and `apps/*/tests/Unit/`.
- Integration tests: `tests/Integration/` and `apps/*/tests/Integration/`.
- Run: `make test` or the full `make check`.

### Documentation

- If you add a new pattern, layer rule or module convention — document it in `docs/conventions/`.
- If you add a new agent role — follow the format in `docs/agents/roles/`.

## Pull request process

1. Create a branch from `master`.
2. Make your changes with clear, descriptive commits.
3. Run `make check` and ensure everything passes.
4. Open a PR with a clear description of what changed and why.
5. Wait for review.

### Commit messages

Use conventional commit format:

```
type(scope): description

feat(diagnostics): add memory usage to runtime check
fix(kernel): resolve duplicate module detection edge case
docs(readme): update quick start section
chore(deps): bump phpunit to 10.5
```

## Questions?

Open an issue with the `question` label.
