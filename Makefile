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

kafka_list:
	$(COMPOSE) exec kafka kafka-topics.sh --list --bootstrap-server localhost:9092
kafka_consume_pdf:
	$(COMPOSE) exec kafka kafka-console-consumer.sh --bootstrap-server localhost:9092 --topic pdf --group historic
