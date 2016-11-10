COMPOSE=docker-compose

.PHONY: all test mostlyclean clean

all:
	$(COMPOSE) build
	$(COMPOSE) up -d

vendor: composer.json
	docker exec --user=$$(id -u):$$(id -g) dlemp_cmd_1 composer install

test:
	docker exec --user=$$(id -u):$$(id -g) dlemp_cmd_1 phpunit --exclude-group=prod
	docker exec --user=$$(id -u):$$(id -g) dlemp_phpfpm_1 vendor/bin/phpunit --exclude-group=cmd,prod

mostlyclean:
	$(COMPOSE) down -v
	$(RM) -r vendor

clean:
	$(COMPOSE) down -v --rmi all
	$(RM) vendor
