up: docker-up
down: docker-down
build: docker-build

docker-up:
	docker-compose up -d
docker-down:
	docker-compose down --remove-orphans
docker-build:
	docker-compose build

yarn-compile:
	yarn encore dev
yarn-watch:
	yarn encore dev --watch


### docker-compose run --rm admin-php-fpm
### docker-compose run --rm admin-php-fpm php bin/console make:migration
### docker-compose run --rm admin-php-fpm php bin/console doctrine:migrations:migrate
### docker-compose run --rm admin-php-fpm php bin/console doctrine:fixtures:load
### curl -X POST -H "Content-Type: application/json" http://localhost:9999/auth/login -d "{\"email\":\"user4@gmail.com\",\"password\":\"123\"}"