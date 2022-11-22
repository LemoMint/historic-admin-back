COMPOSE = docker-compose

init:
	make up
	$(COMPOSE) exec php composer install
up:
	$(COMPOSE) build
	$(COMPOSE) up -d
exec_php:
	$(COMPOSE) exec php bash
exec_db:
	$(COMPOSE) exec db bash
stop:
	$(COMPOSE) down
