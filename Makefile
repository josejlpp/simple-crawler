init:
	@docker-compose exec web php artisan migrate


install:
	@docker-compose up -d
	@docker-compose exec web composer install
	@docker-compose exec web php artisan key:generate
	@docker-compose exec web cp .env.example .env
	@docker-compose exec web php artisan migrate
	@docker-compose exec web php artisan migrate --env=testing
