COMPOSE = docker-compose

init:
	make up
	$(COMPOSE) exec php composer install
build: 
	$(COMPOSE) build
	$(COMPOSE) up -d
up: 
	$(COMPOSE) up -d
ps: 
	$(COMPOSE) ps
up_new:
	$(COMPOSE) build
	$(COMPOSE) up -d
	$(COMPOSE) exec -it -u 0 php chown 1000:www-data /var/www/documents
	make kafka_set_topics
	$(COMPOSE) exec php php artisan migrate:fresh --seed
reboot:
	make delete
	make up_new

exec_php:
	$(COMPOSE) exec php bash
exec_proxy:
	# $(COMPOSE) exec -u 0 php-proxy bash
	$(COMPOSE) exec php-proxy bash
exec_db:
	$(COMPOSE) exec db bash
stop:
	$(COMPOSE) down
delete:
	$(COMPOSE) down -v
kafka_set_topics:
	$(COMPOSE) exec kafka kafka-topics.sh --create --bootstrap-server localhost:9092 --topic pdf
	$(COMPOSE) exec kafka kafka-topics.sh --create --bootstrap-server localhost:9092 --topic mp3
	$(COMPOSE) exec kafka kafka-topics.sh --create --bootstrap-server localhost:9092 --topic mp4
	$(COMPOSE) exec kafka kafka-topics.sh --create --bootstrap-server localhost:9092 --topic images
kafka_list:
	$(COMPOSE) exec kafka kafka-topics.sh --list --bootstrap-server localhost:9092
kafka_consume_pdf:
	$(COMPOSE) exec kafka kafka-console-consumer.sh --bootstrap-server localhost:9092 --topic .pdf --group documents
