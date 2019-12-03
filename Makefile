up: docker-up
down: docker-down
build: docker-build

adut: docker-admin-unit-tests
aput: docker-api-unit-tests

deploy: deploy-production

### Docker init
docker-up:
	docker-compose up -d
docker-down:
	docker-compose down --remove-orphans
docker-build:
	docker-compose build

### Run unit tests
docker-admin-unit-tests:
	docker-compose run --rm admin-php-fpm php bin/phpunit
docker-api-unit-tests:
	docker-compose run --rm api-php-fpm php bin/phpunit

### Build css, js resources
yarn-compile:
	yarn encore dev
yarn-watch:
	yarn encore dev --watch


### Deploy production
deploy-production:
	ssh -o StrictHostKeyChecking=no 185.65.244.241 -p 22 'sudo rm -rf docker-compose.yml'
	scp -o StrictHostKeyChecking=no -P 22 docker-compose-production.yml 185.65.244.241:docker-compose.yml
	ssh -o StrictHostKeyChecking=no 185.65.244.241 -p 22 'sudo rm -rf client/src/app/globals.ts'
	scp -o StrictHostKeyChecking=no -P 22 client/src/app/globals-production.ts 185.65.244.241:client/src/app/globals.ts
	ssh -o StrictHostKeyChecking=no 185.65.244.241 -p 22 'docker-compose build'
	ssh -o StrictHostKeyChecking=no 185.65.244.241 -p 22 'docker-compose up -d'



### docker-compose run --rm admin-php-fpm
### docker-compose run --rm api-php-fpm
### docker-compose run --rm admin-php-fpm php bin/console make:migration
### docker-compose run --rm admin-php-fpm php bin/console doctrine:migrations:migrate
### docker-compose run --rm admin-php-fpm php bin/console doctrine:fixtures:load
### curl -X POST -H "Content-Type: application/json" http://localhost:9999/auth/login -d "{\"email\":\"user@gmail.com\",\"password\":\"123\"}"
### npm install rxjs@6.0.0 --save
### --disable-host-check to package.json start
### docker-compose run --rm admin-php-fpm php php bin/phpunit