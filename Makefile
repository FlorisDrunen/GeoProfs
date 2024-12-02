all: up

# Start services
up:
	docker compose --env-file=src/backend/.env up --build --remove-orphans --force-recreate

migrate:
	cd ./src/backend && docker-compose exec backend php artisan migrate

migrate-test:
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
