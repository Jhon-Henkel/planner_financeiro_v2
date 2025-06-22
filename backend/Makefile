bash:
	@echo "Starting bash..."
	docker compose start && docker exec -it pf_backend bash

tail:
	@echo "Tailing logs..."
	tail -f -n 100 storage/logs/laravel.log

deploy:
	@echo "Deploy im progress..."
	php artisan optimize && php artisan migrate --force

tinker:
	@echo "Starting Tinker..."
	docker exec -it pf_backend php artisan tinker

PHONY: bash tail deploy tinker
