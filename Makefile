be-bash:
	@echo "Starting backend bash..."
	docker compose start && docker exec -it pf_backend bash

be-logs:
	@echo "Tailing logs..."
	tail -f -n 100 backend/storage/logs/laravel.log

tinker:
	@echo "Starting Tinker..."
	docker exec -it pf_backend php artisan tinker

install:
	@echo "Installing project..."
	cp config/develop/docker/docker-compose.yml docker-compose.yml && \
	docker compose up -d --build && \
    docker exec ec_backend /bin/bash -c "composer install" && \
    cp backend/.env.example backend/.env && \
    docker exec pf_backend /bin/bash -c "php artisan key:generate" && \
    docker exec pf_backend /bin/bash -c "php artisan migrate --seed --force" && \

PHONY: be-bash be-logs tinker install
