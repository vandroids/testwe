up:
	docker-compose up -d

down:
	docker-compose down --remove-orphans

build:
	docker-compose build

bash:
	docker-compose exec php bash

dbash:
	docker-compose exec database bash

dbreset:
	docker-compose exec php bash -c 'php bin/console doctrine:database:drop --force || exit 0'
	docker-compose exec php bash -c 'php bin/console doctrine:database:create && exit 0'
	docker-compose exec database bash -c 'mysql -usymfony -psymfony symfony < /test-cinemahd-database.sql'
	docker-compose exec database bash -c 'mysql -usymfony -psymfony symfony < /test-cinemahd-datas.sql'
