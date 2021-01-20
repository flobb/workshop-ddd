DOCKER_COMPOSE=docker-compose
TOOLS = $(DOCKER_COMPOSE) run --rm tools

stop: ## Kill all containers
	$(DOCKER_COMPOSE) kill

clean: ## Remove all containers with their volumes
	$(DOCKER_COMPOSE) down -v --remove-orphans || true

build: ## Build all docker images
	$(DOCKER_COMPOSE) pull
	$(DOCKER_COMPOSE) build

start: ## Start containers and make sure they are ready
	$(DOCKER_COMPOSE) up --no-recreate --remove-orphans -d
	$(DOCKER_COMPOSE) run --rm wait

vendors: ## Install any project dependencies
	$(TOOLS) composer install
	$(TOOLS) bin/console cache:clear
	$(TOOLS) bin/console assets:install --symlink --relative

database: ## Create database and load migrations
	$(TOOLS) bin/console doctrine:database:create -n --if-not-exists
#	$(TOOLS) bin/console doctrine:migration:migrate -n

fixture: ## Load database fixtures
#	$(TOOLS) bin/console hautelook:fixtures:load -n

restart: clean install ## Clean containers and volumes and install the project

install: build start vendors database fixture ## Bootstrap the whole project

cs: ## Automatically fix php code style
	$(TOOLS) vendor/bin/php-cs-fixer fix

cs-lint: ## Detect any php code style issue
	$(TOOLS) vendor/bin/php-cs-fixer fix --dry-run --diff

phpunit: ## Run phpunit tests
	$(TOOLS) bin/phpunit

behat: ## Run behat tests
	$(TOOLS) vendor/bin/behat

test: phpunit behat ## Run all tests
