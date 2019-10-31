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