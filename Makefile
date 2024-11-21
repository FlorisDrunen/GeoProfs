# Default environment
ENV_FILE ?= ./src/backend/.env

# Include environment variables
include $(ENV_FILE)

all: up

# Start services
up:
	docker compose --env-file=$(ENV_FILE) up --build --remove-orphans --force-recreate

# Start testing services
up-test:
	docker compose --env-file=./src/backend/.env.testing up --build --remove-orphans --force-recreate

migrate:
	cd ./src/backend && docker-compose exec backend php artisan migrate

migrate_test:
	cd ./src/backend && docker-compose exec backend php artisan migrate --env=testing


# Run tests
test:
	@echo "Running tests with testing environment..."
	cd ./src/backend && docker compose exec backend php artisan test --env=testing

# Restart the application
restart: up

restart-%:
	up-$*

# Stop the application
down:
	docker compose down --remove-orphans

down-%:
	docker compose down --remove-orphans $*

# Shell into a specific service
shell-%:
	docker compose exec $* bash
