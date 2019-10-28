up: docker-up
down: docker-down
build: docker-build

docker-up:
	docker-compose up -d
docker-down:
	docker-compose down --remove-orphans
docker-build:
	docker-compose build