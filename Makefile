.PHONY: help up tests stop seed-test-data

help:  ##Shows all available commands
	@awk 'BEGIN {FS = ":.*##"; printf "\n\033[32m Makefile\033[0m\n\nUsage:\n  make \033[36m<target>\033[0m\n\nTargets:\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-20s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

up: ##Wakes up the application
	@docker compose up -d

stop: ##Stop the dockers to shut down the system
	@docker compose down --volumes --remove-orphans

