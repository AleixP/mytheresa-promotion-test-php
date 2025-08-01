.PHONY: help up migrate tests down data-seed

help:  ##Shows all available commands
	@awk 'BEGIN {FS = ":.*##"; printf "\n\033[32m Makefile\033[0m\n\nUsage:\n  make \033[36m<target>\033[0m\n\nTargets:\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-20s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

up: ##Wakes up the application
	@docker compose up -d
	@composer install
	@make migrate
	bash scripts/seed-db.sh

shell: ##Opens an interactive shell
	@docker compose exec -it php bash
migrate: ##Executes pending database migrations if any
	@docker compose exec -T php bin/console --no-interaction doctrine:migrations:migrate

down: ##Stop the dockers to shut down the system
	@docker compose down --volumes --remove-orphans

data-seed: ##Forces the data deletion on the database and starts again importing the seeds from JSON files
	bash scripts/seed-db.sh --overwrite

tests-unit: ##Run the tests under the Unit folder
	@php bin/phpunit --testsuite=unit

tests-acceptance: ##Run the tests under Acceptance folder
	@docker compose exec -T php vendor/bin/codecept run

tests: ##Runs all the tests locally
	@php bin/phpunit
	@make tests-acceptance

test: #alias for make tests
	@make tests

