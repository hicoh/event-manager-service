SERVICE_TARGET := app

FILE:=composer.json
PACKAGE_VERSION:=$(shell cat $(FILE) | grep version| tr -d 'version: [[:space:]],')
PHPEXEC=docker-compose exec app

.DEFAULT_GOAL=help

.PHONY: deps

.PHONY: build rebuild start stop

build:	## Build the app docker container.
	@docker-compose build $(SERVICE_TARGET)
	make deps

deps:
	make start
	$(PHPEXEC) composer install -n --prefer-dist
	make stop

rebuild:	## Force a rebuild of the app docker image.
	@docker-compose build --pull --no-cache --force-rm $(SERVICE_TARGET)
	make deps

start: ## Run as a background service.
	@docker-compose -f docker-compose.yml up -d

stop: ## Stop services.
	@docker-compose -f docker-compose.yml stop

ssh: ## ssh access
	@docker-compose exec app bash

lint: phplint phpstan phpcs	## Perform a codebase analysis.

phplint:	## Syntax checking
	@docker-compose exec app ./vendor/bin/parallel-lint --no-progress --exclude bin --exclude var --exclude vendor --blame src
phpstan:	## Perform a static codebase analysis.
	@docker-compose exec app ./vendor/bin/phpstan analyze --no-progress --level=5 src
phpcs:	## Check Code Syntax
	@docker-compose exec app php ./vendor/bin/php-cs-fixer --config=./.php-cs-fixer.php fix -v --dry-run --stop-on-violation src
csfix:	## Fix Syntax
	@docker-compose exec app php ./vendor/bin/php-cs-fixer --config=./.php-cs-fixer.php fix -v --stop-on-violation src

test:	## Run Unit Tests
	@docker-compose exec app php ./vendor/bin/phpunit

## Create a new release
checkout:	## Checkout master branch
	@echo "============ Checkout master branch ============"
	git checkout master && git pull
release:
	@echo "============ Create release branch ============"
	git branch -m "release-v$(PACKAGE_VERSION)"
tag:
	@echo "============ Tag creation ============"
	git tag -a "v$(PACKAGE_VERSION)" -m "Release v$(PACKAGE_VERSION)"
commit:
	@echo "============ Release building  ============"
	git add .
	git commit -m "Release v$(PACKAGE_VERSION)"

version: release commit tag	## Push new version to github
	@echo "============ Push version to origin ============"
	git push origin "release-v$(PACKAGE_VERSION)" --tags
	git checkout master

.PHONY: help
help: ## Show this help.
	@echo ""
	@echo "Usage:"
	@echo "  make [targets...]"
	@echo ""
	@echo "Targets:"
	@awk -F ':|##' '/^[^\t].+?:.*?##/ {\
		printf "  \033[36m%-20s\033[0m %s\n", $$1, $$NF \
	}' $(MAKEFILE_LIST)