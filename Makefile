.PHONY: install validate lint docs todo agents architecture test tests-unit tests-integration tests-integration-path tests-integration-filter check console-about web-routes

install:
	composer install

validate:
	composer validate --strict

lint:
	vendor/bin/parallel-lint --exclude vendor --exclude var .
	vendor/bin/phpcs --standard=phpcs.xml src apps tests

docs:
	vendor/bin/validate-md-links
	php vendor/prikotov/coding-standard/bin/validate-docs.php docs/conventions

todo:
	vendor/bin/todo-md-validate todo

agents:
	php vendor/prikotov/task-orchestrator/bin/validate-roles docs/agents/roles/team

architecture:
	vendor/bin/deptrac analyse --config-file=depfile.yaml --no-progress

test: tests-unit tests-integration

tests-unit:
	vendor/bin/phpunit --testsuite Unit

tests-integration:
	vendor/bin/phpunit --testsuite Integration

tests-integration-path:
	vendor/bin/phpunit $(TEST_PATH)

tests-integration-filter:
	vendor/bin/phpunit --testsuite Integration --filter "$(TEST_FILTER)"

check: validate lint docs todo agents architecture test

console-about:
	php bin/console about --id=console

web-routes:
	php bin/console debug:router --id=web
